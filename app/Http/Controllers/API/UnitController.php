<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function all(Request $request)
    {
        $unit = Unit::all();
        return response()->json(['data'=> $unit ]);
    }

    public function add(Request $request){
        $data = Unit::create([
            'name' => $request->name,
        ]);
        return response()->json(['data'=> $data ]);
    }

}
