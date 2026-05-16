<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        
        // Permissive CSP for development and production asset loading
        $csp = "default-src 'self' *; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https:; "
             . "style-src 'self' 'unsafe-inline' http: https:; "
             . "style-src-elem 'self' 'unsafe-inline' http: https:; "
             . "img-src 'self' data: blob: http: https:; "
             . "font-src 'self' data: http: https:; "
             . "connect-src 'self' ws: wss: http: https:;";
             
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
