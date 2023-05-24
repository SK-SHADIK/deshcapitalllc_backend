<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use DB;

class APIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("Authorization");
        if ($token) {
            $query = "SELECT * FROM tokens WHERE token_key = ? AND expired_at IS NULL LIMIT 1;";
            $key = DB::select($query, [$token]);
            
            if ($key) {
                return $next($request);
            } else {
                return response()->json(["msg" => "Supplied Token Is Invalid or Expired!!! Please Login and Try Again."], 401);
            }
    
        } else {
            return response()->json(["msg" => "Unauthorized!!! No Token Supplied. Please Login and Try Again."], 401);
        }
    }
}
