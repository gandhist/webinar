<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AdminMiddleware
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
        $allow = [1,5]; // define allowed role id in this admin middleware
        if($request->user() && !in_array($request->user()->role_id, $allow) )
            return Response(view('unauthorized')->with('role', 'Admin IT'));
        return $next($request);
    }
}
