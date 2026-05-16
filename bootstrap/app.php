<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \App\Http\Middleware\RoleRedirect::class,
            \App\Http\Middleware\SetSecurityHeaders::class,
        ]);

        $middleware->api(prepend: [
            'throttle:api',
        ]);
        
        $middleware->web(prepend: [
            'throttle:60,1',
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e, $request) {
            if (! app()->environment('local') && in_array($e->getStatusCode(), [403, 404])) {
                return \Inertia\Inertia::render('Errors/' . ($e->getStatusCode() === 403 ? 'Forbidden' : 'NotFound'), [
                    'status' => $e->getStatusCode(),
                ])->toResponse($request)->setStatusCode($e->getStatusCode());
            }
            
            // For testing/local we might want to see them too if we force it
            if (in_array($e->getStatusCode(), [403, 404])) {
                 return \Inertia\Inertia::render('Errors/' . ($e->getStatusCode() === 403 ? 'Forbidden' : 'NotFound'), [
                    'status' => $e->getStatusCode(),
                ])->toResponse($request)->setStatusCode($e->getStatusCode());
            }

            return null;
        });
    })->create();
