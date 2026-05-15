<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If user is accessing '/' or '/dashboard', redirect them based on role
            if ($request->is('/') || $request->is('dashboard')) {
                if ($user->hasRole('teacher')) {
                    return redirect()->route('dashboard.courses.index');
                }
            }
        }

        return $next($request);
    }
}
