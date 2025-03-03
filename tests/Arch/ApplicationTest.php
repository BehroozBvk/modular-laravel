<?php

declare(strict_types=1);

/**
 * Application Layer Tests
 * 
 * These tests ensure that the application layer follows our architectural principles.
 * The application layer contains services, use cases, and interfaces that orchestrate
 * domain objects and infrastructure components.
 */

// Services should be properly structured
it('ensures services are properly structured', function () {
    // Services should be in the Application namespace and follow naming conventions
    arch()
        ->expect('Modules\*\Application\Services')
        ->toBeClasses()
        ->toHaveSuffix('Service');

    // Services should be final classes
    arch()
        ->expect('Modules\*\Application\Services')
        ->toBeFinal();

    // Services should be properly documented
    arch()
        ->expect('Modules\*\Application\Services')
        ->toHaveMethodsDocumented();
});

// Services should depend on repositories
it('ensures services use repositories through interfaces', function () {
    // Services should depend on repository interfaces
    arch()
        ->expect('Modules\*\Application\Services')
        ->toUse('Modules\*\Application\Repositories\*RepositoryInterface')
        ->not->toUse('Modules\*\Infrastructure\Repositories');
});

// DTOs should be immutable
it('ensures DTOs are immutable value objects', function () {
    arch()
        ->expect('Modules\*\Application\DTOs')
        ->toBeClasses()
        ->toBeFinal()
        ->toBeReadonly();
});

// Use cases should be single responsibility
it('ensures use cases follow single responsibility principle', function () {
    // Use cases should be invokable
    arch()
        ->expect('Modules\*\Application\UseCases')
        ->toBeInvokable();

    // Use cases should only have one public method besides constructor
    arch()
        ->expect('Modules\*\Application\UseCases')
        ->toOnlyHavePublicMethodsBesides(['__construct'], ['__invoke']);
});

// Application interfaces should be cohesive
it('ensures application interfaces are cohesive', function () {
    // Repository interfaces should have at most 10 methods
    arch()
        ->expect('Modules\*\Application\Repositories\*RepositoryInterface')
        ->toHaveMaxNumberOfPublicMethods(10);
});

// Event listeners should be in application layer
it('ensures event listeners are properly structured', function () {
    arch()
        ->expect('Modules\*\Application\Listeners')
        ->toBeClasses()
        ->toHaveMethodNamed('handle');

    // Listeners should listen to domain events
    arch()
        ->expect('Modules\*\Application\Listeners')
        ->toUse('Modules\*\Domain\Events');
});
