<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $role): Response
    // {
    //     if ($request->user()->role !== $role) {
    //         return response(view('errors.403'));
    //     }
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next, $role): Response
    {
        foreach (explode("|", $role) as $r) {
            if ($request->user()->role == $r) {
                return $next($request);
            }
        }
        return response(view('errors.403'));
    }
}
