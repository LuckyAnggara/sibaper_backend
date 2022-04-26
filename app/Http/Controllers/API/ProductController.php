<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $name = $request->input('name');
        $limit = $request->input('limit', 6);

        $product = Product::with(['unit','type']);

        if($name)
        {
            $product->where('name','like','%'.$name.'%');
        }
  

 


        return response()->json(['data'=> $product->orderBy('created_at','desc')->paginate($limit) ]);
    }

    public function store(Request $request)
    {
        $master = Product::create([
            'name' => $request->name,
            'description' => $request->desc,
            'type_id' => $request->type,
            'unit_id' => $request->unit,
        ]);

        if($master)
        {
            $mutation = Mutation::create([
                'product_id' => $master->id,
                'debit' => 0,
                'kredit' => 0,
                'keterangan' => 'Saldo Awal'
            ]);
        }

        if($mutation){
            return response()->json(['data'=> $master]);
        }
    }
}
