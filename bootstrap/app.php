<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RequireRole;
use App\Http\Middleware\SetCurrentCompany;
use App\Http\Middleware\EnsureCompanyIsSubscribed;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->append(SetLocale::class);

        // Route middleware aliases for role-based access, tenancy and billing
        $middleware->alias([
            'role'       => RequireRole::class,
            'tenant'     => SetCurrentCompany::class,
            'subscribed' => EnsureCompanyIsSubscribed::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
