<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('limit', 5);

        $user = User::query();
        $user->orWhereNot('role','ADMIN');

        if($search)
        {
            $user->where(function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%')
                ->orWhere('nip','like','%'.$search.'%')
                ->orWhere('status','like','%'.$search.'%');
            });

            
        }
        return response()->json(['data'=> $user->paginate($limit) ]);
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
}
