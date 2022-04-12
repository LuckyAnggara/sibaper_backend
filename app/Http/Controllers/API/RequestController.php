<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Request as ModelsRequest;
use App\Models\RequestDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json(['data'=> $request->paginate($limit) ]);
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

}
