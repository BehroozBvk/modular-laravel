<?php

declare(strict_types=1);

// Auth module specific rules
it('enforces Auth module specific rules', function () {
    // Auth service should use User repository
    arch()
        ->expect('Modules\Auth\Application\Services')
        ->toUse('Modules\User\Interfaces\Repositories\UserRepositoryInterface');

    // Auth controllers should use Auth services
    arch()
        ->expect('Modules\Auth\Http\Controllers')
        ->toUse('Modules\Auth\Services');

    // Auth controllers should return appropriate responses
    arch()
        ->expect('Modules\Auth\Http\Controllers')
        ->toUse('Modules\Auth\Http\Resources');
});

// User module specific rules
it('enforces User module specific rules', function () {
    // User repository should implement UserRepositoryInterface
    arch()
        ->expect('Modules\User\Repositories')
        ->toImplement('Modules\User\Interfaces\Repositories\UserRepositoryInterface');

    // User model should be in the User module
    arch()
        ->expect('Modules\User\Models\User')
        ->toBeClasses()
        ->toExtend('Illuminate\Foundation\Auth\User');
});

// Separation of concerns between modules
it('enforces separation of concerns between modules', function () {
    // Auth module should not depend on implementation details of User module
    arch()
        ->expect('Modules\Auth')
        ->not->toUse('Modules\User\Repositories')
        ->ignoring('Modules\Auth\Tests');

    // Each module should only depend on other modules through interfaces
    arch()
        ->expect('Modules\*')
        ->not->toUse('Modules\*\Infrastructure')
        ->ignoring([
            'Modules\*\Infrastructure',
            'Modules\*\Tests',
            'Modules\*\Providers'
        ]);
});
