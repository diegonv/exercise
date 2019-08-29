<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdminApi
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
        if(Auth::guard('api')->user()->isAdmin()){
            return $next($request);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
