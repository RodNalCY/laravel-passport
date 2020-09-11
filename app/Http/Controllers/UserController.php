<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class UserController extends Controller
{
    public function index(Request $request){
        return response()->json(['Hello'=>"Bienvenido a Telemedicina"],200);
    }

    public function registro(Request $request) {

        $neo_user = User::create($request->all());
        $getUserID = $neo_user->id; // Obtenemos el ultimo ID creado

        return response()->json([
            'userID' => $getUserID,
            'message' => 'saved :)',
            'status' => true
        ], 200);
    }

    public function signup(Request $request){
        try{
            $this->validate($request,[
               'id_user' => 'required|min:1',
               'email' => 'required|email|unique:users',
               'password' => 'required|string',
               'remember_me' => 'boolean'
            ]);


            $user = User::find($request->id_user);

            if($user!=null){
                $user->email    = $request->email;
                $user->password = $request->password;

                if($user->update()){

                    $token_result = $user->createToken('TelemedicinaToken');
                    $token = $token_result->token;
                    if ($request->remember_me){
                        $token->expires_at = Carbon::now()->addWeeks(1);
                    }
                    $token->save();
                    return response()->json([
                        'token_type' => 'Bearer',
                        'access_token' => $token_result->accessToken,
                        'usuario' => $user,
                        'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                        'status' => true
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'inicie su registro',
                    'status'  => 'error'
                ]);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], 422);
        }

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email','password']);

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
            'usuario' => $user,
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'status' => true
        ]);
    }

    public function logout(Request $request){
        //funcion para revocar el Token es decir invalidar el token y se representa con estado '1' en la tabla 'oauth_access_tokens'
        try{
            $request->user()->token()->revoke();
            return response()->json([
                'message' =>  "Successfully logged out",
                'status' => false
            ]);

        } catch (Exception $ex) {
            return response()->json(['error' => $ex]);
        }

    }

    public function users(Request $request){
        return response()->json($request->user());
    }

    public function reniec(Request $request){

        return $request;

    }

}
