<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Api\BaseController;

use App\Models\User;

class TokenAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization'); // Retrieve the token from the request header
        // Verify the token and authenticate the user
        // You can validate the token against the stored tokens in the database
        if (!$token || !$this->isValidToken($token)) {
            //throw new AuthenticationException('Invalid token');
            //return response()->json(['message' => 'Authentication failed'], 401);
            return (new BaseController)->sendError('Invalid token! Please login again', "404");  
        }
        
        return $next($request);
    }
    
    private function isValidToken($token)
    {
        $token = $token;
        
        // Remove the "Bearer " prefix from the token
        $token = str_replace(["Bearer", "bearer", " "], "", $token); 
        $user=User::where('token', $token)->first();
        // Implement your token verification logic here
        // Check if the token is valid and associated with an active user
         if(!$user){
            //return response(['message' => 'Token Not Found.'], 200);
            return false;
        } else{
            return true;
        }
        
       // return true; // Return true if the token is valid, false otherwise
    }
}
