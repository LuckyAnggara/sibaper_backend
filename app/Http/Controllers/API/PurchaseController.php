<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Mutation;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\MutationController;

class PurchaseController extends Controller
{
    public function all(Request $request)
    {
        $notes = $request->input('notes');
        $limit = $request->input('limit', 6);

        $request = Purchase::with(['user'])->where('user_id', Auth::user()->id);
        
        if($notes)
        {
            $request->where('notes','like','%'.$notes.'%');
        }

        return response()->json(['data'=> $request->latest()->paginate($limit) ]);
    }

    public function store(Request $request)
    {
        $master = Purchase::create([
            'user_id' => $request->user_id,
            'notes' => $request->notes,
            'created_at' => $request->tanggal,
        ]);

        if($master)
        {
            $detail = [];
            if($request->detail){
                
                foreach ($request->detail as $key => $value) {
                    $product = Product::findOrFail($value['id']);
                    $data = PurchaseDetail::create([
                        'purchase_id' => $master->id,
                        'product_id' => $value['id'],
                        'quantity' => $value['quantity'],
                    ]);

                    if($data)
                    {
                        $new = Mutation::create([
                            'product_id'=> $value['id'],
                            'debit'=> $value['quantity'],
                            'kredit'=> 0,
                            'keterangan'=> 'Pembelian persediaan-'.Carbon::createFromFormat('Y-m-d', $request->tanggal)->format('dmY').'-'.$request->notes,
                        ]);

                        $update = (new MutationController)->update($value['id']);
                    }
                        
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
        $id = $request->input('id');
        
        $request = Purchase::with(['user','detail.product'])->where('id', $id)->first();
        if($request)
        {
            return response()->json(['data'=> $request]);
        }

        
    }


}
