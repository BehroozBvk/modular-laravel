<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;
use Modules\Core\Http\Middleware\LocalizationMiddleware;
use Clockwork\Support\Laravel\ClockworkMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            CreateFreshApiToken::class,
        ]);
        $middleware->append(LocalizationMiddleware::class);
        $middleware->append(ClockworkMiddleware::class);

        $middleware->alias([
            'auth:api-user' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
            'auth:api-admin' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();
