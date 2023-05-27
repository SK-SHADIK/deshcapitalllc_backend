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
        $authorizationHeader = $request->header("Authorization");
        if($authorizationHeader){
        
            if (strpos($authorizationHeader, 'Bearer') !== false) {
                $token = explode(' ', $authorizationHeader)[1]; // Splitting the Bearer token
            
                if ($token) {
                    $key = Token::where('token_key',$token)->first();
                    if ($key != null) {
                        return $next($request);
                    } else {
                        return response()->json(["msg" => "Supplied Token Is Invalid or Expired!!!  Please Login and Try Again."], 401);
            
                    }
                }else{
                    return response()->json(["msg" => "Supplied Token Is Invalid or Expired!!!  Please Login and Try Again."], 401);
                }
                
            } else {
                return response()->json(["msg" => "Supplied Token Is Invalid or Expired!!!  Please Login and Try Again."], 401);
            } 
        }else {
            return response()->json(["msg" => "Unauthorized!!! No Token Supplied. Please Login and Try Again."], 401);
        }
    }

}
