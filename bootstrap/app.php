<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfNotAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        __DIR__.'/../app/Console/Commands',
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => RedirectIfNotAdmin::class,
            'admin.role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'security.production' => \App\Http\Middleware\ProductionSecurityMiddleware::class,
        ]);

        $middleware->prependToGroup('web', \App\Http\Middleware\ProductionSecurityMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
