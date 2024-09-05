<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class ParentMiddleware
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
       
       $user = auth()->user(); 
        if(!empty($user)){
           if ($user->user_type!=3) {
                abort(403, 'Unauthorized action.');
                return $next($request);
           }
        } else{
            //abort(403, 'Unauthorized action.');
             return redirect('login')->with('success', "Login again");
                return $next($request);
        }
        return $next($request);
    }
}
