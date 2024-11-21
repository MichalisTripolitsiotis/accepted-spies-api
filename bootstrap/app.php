<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::namespace('Auth')
                ->prefix('api/v1')
                ->name('auth.')
                ->group(base_path('routes/auth.php'));
            Route::namespace('Spy')
                ->prefix('api/v1')
                ->name('spy.')
                ->group(base_path('routes/spy.php'));
            Route::namespace('Agency')
                ->prefix('api/v1')
                ->name('agency.')
                ->group(base_path('routes/agency.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
