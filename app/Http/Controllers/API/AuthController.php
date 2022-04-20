<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'nip'=>'required|string|max:255|unique:users',
            'password'=>'required|string|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->error());
        }

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data'=>$user, 'access_token'=> $token, 'token_type'=> 'Bearer']);
    }


    public function changePassword(Request $request)
    {

        $request->validate([
            'password_lama' => ['required', new MatchOldPassword],
            'password_baru' => ['required'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password_baru)]);

        return response()->json('Password change successfully', 200);
   
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $user->update($data);

        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $user = User::where('nip', $request['nip'])->firstOrFail();

        if($user->status == 'DEACTIVE')
        {
            return response()->json(['message'=>'Deactive'], 403);
        }

        if(!Auth::attempt($request->only('nip','password')))
        {
            return response()->json(['message'=>'Unauthorized'],401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

}
