<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function all(Request $request)
    {
        $type = Type::all();
        return response()->json(['data'=> $type ]);
    }

    public function add(Request $request){
        $data = Type::create([
            'name' => $request->name,
        ]);
        return response()->json(['data'=> $data ]);
    }
}
