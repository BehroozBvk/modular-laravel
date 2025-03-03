<?php

declare(strict_types=1);

// Controller naming and structure
it('ensures controllers follow naming conventions', function () {
    arch()
        ->expect('App\Http\Controllers')
        ->toHaveSuffix('Controller');

    arch()
        ->expect('Modules\*\Infrastructure\Http\Controllers')
        ->toHaveSuffix('Controller');
});

// Controller method naming
it('ensures API controllers have standardized method names', function () {
    // API controllers should only have specific method names
    arch()
        ->expect('App\Http\Controllers\Api')
        ->toOnlyHavePublicMethodsBesides(['__construct', '__invoke'], [
            'index',
            'show',
            'store',
            'update',
            'destroy'
        ]);

    arch()
        ->expect('Modules\*\Infrastructure\Http\Controllers\Api')
        ->toOnlyHavePublicMethodsBesides(['__construct', '__invoke'], [
            'index',
            'show',
            'store',
            'update',
            'destroy'
        ]);
});

// Controllers should be lightweight
it('ensures controllers are lightweight and delegate to services', function () {
    // Application services should be used in controllers
    arch()
        ->expect('Modules\*\Application\Services')
        ->toBeUsedIn('Modules\*\Infrastructure\Http\Controllers');

    // No raw queries in controllers
    arch()
        ->expect(['DB', 'Illuminate\Support\Facades\DB'])
        ->not->toBeUsedIn('App\Http\Controllers');

    arch()
        ->expect(['DB', 'Illuminate\Support\Facades\DB'])
        ->not->toBeUsedIn('Modules\*\Infrastructure\Http\Controllers');
});

// Single-action controllers should be invokable
it('ensures single-action controllers are invokable', function () {
    arch()
        ->expect('App\Http\Controllers\*\*Controller')
        ->toBeInvokable();

    arch()
        ->expect('Modules\*\Infrastructure\Http\Controllers\*\*Controller')
        ->toBeInvokable();
});
