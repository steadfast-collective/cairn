<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function() {
            if(config('app.env') === 'local') {
                Route::prefix('dev')
                    ->middleware('web')
                    ->name('dev.')
                    ->middleware('web')
                    ->group(base_path('routes/dev.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn (Request $request) => route('auth.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
