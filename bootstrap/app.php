<?php

use App\Http\Middleware\Cors;
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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            \App\Http\Middleware\ThemeMiddleware::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            Cors::class,
            \Illuminate\Http\Middleware\TrustHosts::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Modules\Auth\App\Http\Middleware\AuthChecker::class,
            \App\Http\Middleware\PreventBackHistory::class,
        ]);
        $middleware->trustProxies(at: '*');
        $middleware->trustHosts(at: explode(',', env('TRUSTED_HOSTS', 'localhost')));
        $middleware->redirectGuestsTo(fn(Request $request) => route('auth.login'));
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
