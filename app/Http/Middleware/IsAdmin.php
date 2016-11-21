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
        log::info("entro a  isAdmin");
        $token_key = getallheaders()["Authorization"];
        $token = Token::where('token', $token_key) -> get() -> first();
        if ($token) {
            $type = $token -> user -> type;
            if ($type == 'admin' or $type == 'admin' or $type == 'asistente' or $type == 'asesor' or $type == 'bodega' or $type == 'director') {
                $request->merge(array("user_id" =>  $token -> user -> id));
                log::info($request);
                log::info($token -> user -> id);
                return $next($request);
            }     
        }
        return Response() -> Json(['message' => 'error'], 400);
        
    }
}
