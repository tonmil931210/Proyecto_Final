<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SessionRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Token;
use Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class SessionsController extends Controller
{


    public function login(SessionRequest $request){
    	$email = $request -> email;
    	#log::info(strval($email));
    	$password = $request -> password;
    	log::info("entre1");
        $user = User::where('email', $email) -> first();
        log::info($user);
        if ($user) {
            $id = $user -> id;
            $user_password = crypt::decrypt(User::find($id) -> password);
            log::info($user_password);
            log::info($password);
            if ($user_password == $password) {
                do {
                    $token = Str::random(60);
                    #log::info($token);
                } while (!Token::where("token", $token) -> get());
                #log::info($user);
                Token::create(['token' => $token, 'user_id' => $id]);
                return Response() -> Json(['message' => 'successful', 'token' => $token], 200) -> header("Authorization", $token);
            } else {
                return Response() -> Json(['message' => 'error'], 400);
            } 
        } else {
            return Response() -> Json(['message' => 'error'], 400);
        }
    	

    }

    public function logout(){
    	$token_key = getallheaders()["Authorization"];
    	$user = Token::where('token', $token_key) -> get() -> first();
    	if ($user) {
    		Token::destroy($user -> id);
    		return Response() -> Json(['message' => 'ok'], 200);
    	} else {
    		return Response() -> Json(['message' => 'error'], 400);
    	}
    	

    }
}
