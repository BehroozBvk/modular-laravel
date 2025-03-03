<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            CreateFreshApiToken::class,
        ]);

        $middleware->alias([
            'auth:api-user' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
            'auth:api-admin' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();
