<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'KZ_Module_B/api'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.token' => \App\Http\Middleware\CheckToken::class,
            'check.admin' => \App\Http\Middleware\CheckAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, \Illuminate\Http\Request $request) {
            if (!$request->is('KZ_Module_B/api/*'))
            {
                return null;
            }

            if ($e instanceof \Illuminate\Validation\ValidationException)
            {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => array_map(fn ($messages) => $messages[0], $e->errors())
                ], 422);
            }

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
            {
                return response()->json([
                    'message' => 'Resource not found'
                ], 404);
            }

            return null;
        });
    })->create();
