<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('admin')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
