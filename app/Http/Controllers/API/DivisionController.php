<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function all(Request $request)
    {
        $data = Division::all();
        return response()->json(['data'=> $data ]);
    }
}
