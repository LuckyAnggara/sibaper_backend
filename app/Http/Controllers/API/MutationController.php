<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Mutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MutationController extends Controller
{
    public function store($data)
    {
     
    }

    public function update($id)
    {
        $product = Product::findOrFail($id);
        if($product){
            $debit = DB::table('mutations')->where('product_id', $id)->sum('debit');
            $kredit = DB::table('mutations')->where('product_id', $id)->sum('kredit');
    
            $saldo = $debit - $kredit;
    
            $product->quantity = $saldo;
            $product->save();
            return true;
        }else{
            return false;
        }
    }

    public function get(Request $request)
    {
        // $search_term = $request->input('search_term');
        // $limit = $request->input('limit', 5);
        // $cast = '@saldo:=@saldo+debit-kredi AS saldo';
        // $cast = 'cast((@saldo:= @saldo+debit-kredit) AS double) AS saldo';
        $cast = 'cast((@saldo:= @saldo) AS double) AS saldo';
        DB::statement(DB::raw('set @saldo=0'));
        $mutation = DB::table('mutations')->selectRaw('product_id, debit,kredit,keterangan,created_at, '.$cast);
        // $mutation = DB::table('mutations')->selectRaw('id,product_id, debit,kredit,keterangan,created_at');
        $mutation = $mutation->where('product_id', $request->id)->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        // $mutation = Mutation::query()->selectRaw($cast)->where('product_id', $request->id);
        // if($search_term)
        // {
        //     $mutation->where('keterangan','like','%'.$search_term.'%');
        // }
        if($mutation)
        {
            return response()->json($mutation->get(), 200);
        } else {
            return response()->json('no data', 400);
        }
    }
}
