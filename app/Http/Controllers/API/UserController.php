<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function all(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('limit', 5);

        $user = User::query();
        $user->orWhereNot('role','ADMIN')->with(['division']);

        if($search)
        {
            $user->where(function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%')
                ->orWhere('nip','like','%'.$search.'%')
                ->orWhere('status','like','%'.$search.'%');
            });
        }
        $user->orderBy('id','DESC');
        return response()->json(['data'=> $user->paginate($limit) ]);
    }


    public function cekNip(Request $request)
    {
        $nip = $request->input('nip');

        $user = User::where('nip', $nip)->first();
        if($user){
          return  response()->json(['message' => true], 200); 
        }else{
            return   response()->json(['message' => false], 200); 
        }
    }

    public function resetPassword(Request $request){
        $id = $request->input('id');


        User::find($id)->update(['password'=> Hash::make('123456')]);

        return response()->json('Password reset successfully', 200);
    }
    
    public function ubahStatus(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');


        $user = User::find($id);
        $user->status = $status;
        $user->update();

        return response()->json('Status user change to '.$status. ' successfully', 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'bagian'=>'required|string|max:255',
            'nip'=>'required|string|max:255|unique:users',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->error());
        }

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'division_id' => $request->division_id,
            'role' => 'USER',
            'password' => Hash::make('123456'),
        ]);
    }
}
