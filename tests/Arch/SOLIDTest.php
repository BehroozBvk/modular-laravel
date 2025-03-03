<?php

declare(strict_types=1);

// Single Responsibility Principle
it('enforces Single Responsibility Principle', function () {
    // Classes should not have too many methods
    arch()
        ->expect(['App', 'Modules'])
        ->classes()
        ->not->toHavePublicMethodsBesides(['__construct', '__invoke', '__toString'], 10);
});

// Open/Closed Principle - enforced through interfaces
it('enforces Open/Closed Principle', function () {
    // Services should depend on interfaces, not concrete implementations
    arch()
        ->expect('Modules\*\Application\Services')
        ->toBeClasses()
        ->toUse('Modules\*\Application\Repositories\*RepositoryInterface')
        ->ignoring(['Modules\*\Tests', 'Modules\*\Application\Services\*Factory']);
});

// Liskov Substitution Principle - enforced through inheritance
it('enforces Liskov Substitution Principle', function () {
    // All repositories must implement their interfaces
    arch()
        ->expect('Modules\*\Infrastructure\Repositories')
        ->toBeClasses()
        ->toImplement('Modules\*\Application\Repositories\*RepositoryInterface');
});

// Interface Segregation Principle
it('enforces Interface Segregation Principle', function () {
    // Interfaces should not have too many methods
    arch()
        ->expect('Modules\*\Application\Repositories\*Interface')
        ->interfaces()
        ->not->toHaveMethods(10);
});

// Dependency Inversion Principle
it('enforces Dependency Inversion Principle', function () {
    // High-level modules should depend on abstractions
    arch()
        ->expect('Modules\*\Application\Services')
        ->toUse('Modules\*\Application\Repositories\*Interface')
        ->not->toUse('Modules\*\Infrastructure\Repositories');

    // Controllers should depend on application services, not infrastructure
    arch()
        ->expect('Modules\*\Infrastructure\Http\Controllers')
        ->toUse('Modules\*\Application\Services')
        ->not->toUse('Modules\*\Infrastructure\Repositories');
});
