<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Mutation;
use Illuminate\Http\Request;
use App\Models\RequestDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as ModelsRequest;

class RequestController extends Controller
{
    public function all(Request $request)
    {
        $no_ticket = $request->input('no_ticket');
        $limit = $request->input('limit', 6);

        $request = ModelsRequest::with(['user'])->where('user_id', Auth::user()->id);
        
        if($no_ticket)
        {
            $request->where('no_ticket','like','%'.$no_ticket.'%');
        }

        return response()->json(['data'=> $request->latest()->paginate($limit) ]);
    }

    public function store(Request $request)
    {
        $master = ModelsRequest::create([
            'user_id' => $request->user_id,
            'notes' => $request->notes,
            'status' => 'PENDING',
            'no_ticket' => '',
        ]);

        if($master)
            $master->no_ticket = Carbon::now()->format('Ymd') . '-' .$master->id;
            $master->save();
        {
            $detail = [];
            if($request->detail){
                
                foreach ($request->detail as $key => $value) {
                    $product = Product::findOrFail($value['id']);
                    $data = RequestDetail::create([
                        'request_id' => $master->id,
                        'product_id' => $value['id'],
                        'quantity' => $value['quantity'],
                    ]);

                    $data['name'] = $product->name;
                    $detail[] = $data;
                }
            }
            $master['detail'] =$detail;
        }
        return response()->json(['data'=> $master]);
    }

    public function get(Request $request)
    {
        $no_ticket = $request->input('no_ticket');
        
        $request = ModelsRequest::with(['user','detail.product'])->where('no_ticket', $no_ticket)->first();
        if($request)
        {
            return response()->json(['data'=> $request]);
        }        
    }

    public function allAdmin(Request $request)
    {

        $status = $request->input('status');
        $no_ticket = $request->input('no_ticket');
        $limit = $request->input('limit', 6);

        
        if($status == 'SEMUA'){
            $request = ModelsRequest::with(['user']);
        }else{
            $request = ModelsRequest::with(['user'])->where('status',$status);
        }
        if($no_ticket)
        {
            $request->where('no_ticket','like','%'.$no_ticket.'%');
        }

        return response()->json(['data'=> $request->latest()->paginate($limit) ]);
    }

    public function getAdmin(Request $request)
    {
        $no_ticket = $request->input('no_ticket');
        $request = ModelsRequest::with(['user','detail.product'])->where('no_ticket', $no_ticket)->first();
        if($request)
        {
            return response()->json(['data'=> $request]);
        }
    }

    public function update(Request $request){
        $id = $request->input('id');
        $master = ModelsRequest::with(['detail'])->find($id);

        if($master)
        {
            $master->status = 'ACCEPT';
            $master->user_admin = Auth::user()->id;
            $master->save();

            foreach ($request->detail as $key => $value) {
                $detail = RequestDetail::find($value['id']);
                $product = Product::find($value['product_id']);
                
                if($value['quantity'] < $product->quantity)
                {
                    $detail->acc_quantity = $value['quantity'];
                    $detail->status = 'ACCEPT';
                    $detail->save();

                    $new = Mutation::create([
                        'product_id'=> $value['product_id'],
                        'debit'=> 0,
                        'kredit'=> $value['quantity'],
                        'keterangan'=> 'Permintaan nomor ticket #'.$master->no_ticket,
                    ]);

                    $update = (new MutationController)->update($value['product_id']);
                }
                else
                {
                    $detail->status = 'REJECT';
                    $detail->save();
                }
            }

            $sisa_detail = RequestDetail::where('request_id', $id)->where('status','PENDING')->get();
            foreach ($sisa_detail as $key => $value) {
                $value->status = 'REJECT';
                $value->save();
            }

        }

    }

    public function destroy($id)
    {
        $master = ModelsRequest::find($id);

        if($master)
        {
            $master->delete();
        }

        return response()->json($master);
    }
}
