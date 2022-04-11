<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $name = $request->input('name');
        $limit = $request->input('limit', 6);

        $product = Product::query();
        if($name)
        {
            $product->where('name','like','%'.$name.'%');
        }

        return response()->json(['data'=> $product->paginate($limit) ]);
    }
}
