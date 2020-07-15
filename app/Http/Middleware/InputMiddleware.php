<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class InputMiddleware
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
        if($request->user() && 
            $request->user()->role_id != 5 && 
            $request->user()->role_id != 4 && 
            $request->user()->role_id != 3 && 
            $request->user()->role_id != 2 && 
            $request->user()->role_id != 1)
            return Response(view('unauthorized')->with('role', 'Admin/Manager/Controller/Supervisor/Security'));
        return $next($request);
    }
}
