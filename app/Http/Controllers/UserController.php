<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request){
        return response()->json(['Hello'=>"Bienvenido a Telemedicina"],200);
    }

    public function signup(Request $request){

        $this->validate($request,[
           'name' => 'required|min:3',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:6'
        ]);

        $user = User::create([
           'name'=> $request->name,
           'email'=> $request->email,
           'password'=> bcrypt($request->password)
        ]);

        $token_result = $user->createToken('TelemedicinaToken');

        $token = $token_result->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token_result->accessToken,
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request([
           'email',
           'password',
        ]);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $token_result = $user->createToken('TelemedicinaToken');

        $token = $token_result->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token_result->accessToken,
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout(Request $request){
        //funcion para revocar el Token es decir invalidar el token y se representa con estado '1' en la tabla 'oauth_access_tokens'
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);


    }

    public function users(Request $request){
      return response()->json($request->user());
    }
}
