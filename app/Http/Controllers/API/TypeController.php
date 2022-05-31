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

    public function store(Request $request)
    {
        $master = Type::create([
            'name' => $request->name,
        ]);

        if($master){
            return response()->json(['data'=> $master]);
        }
        return response()->json(['data'=> 'Error'], 404);

    }

    public function update(Request $request){
        $id = $request->input('id');
        $master = Type::find($id);
        if($master){
            $master->name = $request->name;
            $master->save();

            return response()->json(['data'=> $master], 200);
        }

        return response()->json(['data'=> 'Data Not Found'], 404);
    }

    public function destroy($id)
    {
        $master = Type::find($id);

        if($master)
        {
            $master->name = 'null';
            $master->save();
            $master->delete();
            return response()->json($master);
        }
        return response()->json('data not found', 404);

    }

}
