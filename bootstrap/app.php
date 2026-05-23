<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register alias middleware
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // Tambahkan web middleware defaults jika diperlukan
        $middleware->web(append: [
            // \App\Http\Middleware\SomeMiddleware::class,
        ]);

        // ⭐ FIX: Redirect guest (user belum login) ke route 'auth.login'
        // Karena nama route login di project ini adalah 'auth.login', bukan 'login' (default Laravel)
        $middleware->redirectGuestsTo(fn (Request $request) => route('auth.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();