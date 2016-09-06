<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use App\Token;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token_key = getallheaders()["Authorization"];
        $token = Token::where('token', $token_key) -> get() -> first();
        if ($token) {
            if ($token -> user -> type == 'admin') {
                $request->merge(array("user_id" =>  $token -> user -> id));
                log::info($request);
                log::info($token -> user -> id);
                return $next($request);
            }     
        }
        return Response() -> Json(['message' => 'error'], 400);
        
    }
}
