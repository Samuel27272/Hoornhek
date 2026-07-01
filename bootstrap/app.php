<?php

use App\Http\Middleware\CheckRol;
use App\Http\Middleware\CheckPermission;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'rol' => CheckRol::class,
            'permission' => CheckPermission::class,
            '2fa' => \App\Http\Middleware\EnsureTwoFactorIsEnabled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (QueryException $exception, Request $request) {
            $message = 'Er ging iets mis bij het verwerken van je gegevens. Probeer het opnieuw of neem contact op met beheer.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                ], 500);
            }

            if ($request->isMethod('get')) {
                return response()->view('errors.database', [
                    'message' => $message,
                ], 500);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'database' => $message,
                ]);
        });
    })->create();
