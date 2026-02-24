<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            // se tiene que añadir el middleware de CORS antes que el de Sanctum para que funcione correctamente
            \Illuminate\Http\Middleware\HandleCors::class,          
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'API-KEY' => \App\Http\Middleware\ApiKeyMiddleware::class,  // 'API-KEY' és l'alias del middleware
            'CHECK-ROLEADMIN' => \App\Http\Middleware\CheckRoleAdmin::class,  // 'CHECK-ROLEADMIN' és l'alias del middleware
            'MULTI-AUTH' => \App\Http\Middleware\MultiAuthMiddleware::class,  // 'MULTI-AUTH' és l'alias del middleware
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
            }
        });
    })->create();
