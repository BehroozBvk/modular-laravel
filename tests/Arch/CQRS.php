<?php

declare(strict_types=1);

// Commands should be used for write operations
it('ensures commands are used for write operations', function () {
    arch()
        ->expect('Modules\*\Application\Commands')
        ->toBeClasses()
        ->toBeFinal()
        ->toBeUsedIn([
            'Modules\*\Infrastructure\Http\Controllers\*\StoreController',
            'Modules\*\Infrastructure\Http\Controllers\*\UpdateController',
            'Modules\*\Infrastructure\Http\Controllers\*\DestroyController',
        ])
        ->ignoring('Modules\*\Tests');
});

// Queries should be used for read operations
it('ensures queries are used for read operations', function () {
    arch()
        ->expect('Modules\*\Application\Queries')
        ->toBeClasses()
        ->toBeFinal()
        ->toBeUsedIn([
            'Modules\*\Infrastructure\Http\Controllers\*\IndexController',
            'Modules\*\Infrastructure\Http\Controllers\*\ShowController',
        ])
        ->ignoring('Modules\*\Tests');
});

// Command handlers should be appropriately used
it('ensures command handlers are properly structured', function () {
    arch()
        ->expect('Modules\*\Application\Commands\Handlers')
        ->toBeClasses()
        ->toBeFinal()
        ->toHaveSuffix('Handler')
        ->toBeInvokable();
});

// Query handlers should be appropriately used
it('ensures query handlers are properly structured', function () {
    arch()
        ->expect('Modules\*\Application\Queries\Handlers')
        ->toBeClasses()
        ->toBeFinal()
        ->toHaveSuffix('Handler')
        ->toBeInvokable();
});

// Commands should not be used for read operations
it('ensures commands are not used for read operations', function () {
    arch()
        ->expect('Modules\*\Application\Commands')
        ->not->toBeUsedIn([
            'Modules\*\Infrastructure\Http\Controllers\*\IndexController',
            'Modules\*\Infrastructure\Http\Controllers\*\ShowController',
        ])
        ->ignoring('Modules\*\Tests');
});

// Queries should not be used for write operations
it('ensures queries are not used for write operations', function () {
    arch()
        ->expect('Modules\*\Application\Queries')
        ->not->toBeUsedIn([
            'Modules\*\Infrastructure\Http\Controllers\*\StoreController',
            'Modules\*\Infrastructure\Http\Controllers\*\UpdateController',
            'Modules\*\Infrastructure\Http\Controllers\*\DestroyController',
        ])
        ->ignoring('Modules\*\Tests');
});
