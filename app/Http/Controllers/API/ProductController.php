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
            $date = '25/05/'.date('Y');
            $date = str_replace('/', '-', $date);

            $mutation = Mutation::create([
                'product_id' => $master->id,
                'debit' => 0,
                'kredit' => 0,
                'keterangan' => 'Saldo Awal',
                'created_at' => date("Y-m-d H:i:s", strtotime($date))
            ]);
        }

        if($mutation){
            return response()->json(['data'=> $master]);
        }
    }

    public function update(Request $request){
        $id = $request->input('id');
        $master = Product::find($id);
        if($master){
            $master->name = $request->name;
            $master->description = $request->desc;
            $master->type_id = $request->type_id;
            $master->unit_id = $request->unit_id;
            $master->save();

            return response()->json(['data'=> $master], 200);
        }

        return response()->json(['data'=> 'Data Not Found'], 404);
    }
}
