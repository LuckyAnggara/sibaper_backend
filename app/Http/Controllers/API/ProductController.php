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
        $sort = $request->input('sort','ASC');
        $by = $request->input('by');

        $product = Product::query();
        if($name)
        {
            $product->where('name','like','%'.$name.'%');
        }
        if($by)
        {
            $product->orderBy($by,$sort);
        }

 


        return response()->json(['data'=> $product->paginate($limit) ]);
    }

    public function store(Request $request)
    {
        $master = Product::create([
            'name' => $request->name,
            'description' => $request->desc,
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
