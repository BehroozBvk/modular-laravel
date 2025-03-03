<?php

declare(strict_types=1);

// Ensure proper structure for Modules
it('enforces proper module structure', function () {
    // Each module should have domain, application and infrastructure layers
    arch()
        ->expect('Modules/*')
        ->toBeClassesOrInterfaces()
        ->toHaveNamespace('Modules');
});

// Domain entities should only be used in specific places
it('restricts domain model usage', function () {
    arch()
        ->expect('Modules/*/Domain/Models')
        ->toBeClasses()
        ->toOnlyBeUsedIn([
            'Modules/*/Domain',
            'Modules/*/Application',
            'Modules/*/Infrastructure'
        ])
        ->ignoring([
            'Modules/*/Tests',
            'Modules/*/Database/Factories',
            'Modules/*/Database/Seeders'
        ]);
});

// Ensure DTOs are immutable
it('ensures DTOs are immutable', function () {
    arch()
        ->expect('Modules/*/Domain/DTOs')
        ->toBeClasses()
        ->toBeFinal()
        ->toHaveConstructor();
});

// Services should only depend on repositories, never on models directly
it('ensures services depend only on repositories', function () {
    arch()
        ->expect('Modules/*/Application/Services')
        ->not->toUse('Modules/*/Domain/Models')
        ->ignoring('Modules/*/Tests');
});

// Repositories should implement their interfaces
it('ensures repositories implement their interfaces', function () {
    arch()
        ->expect('Modules/*/Infrastructure/Repositories')
        ->toBeClasses()
        ->toImplement('Modules/*/Application/Repositories/*RepositoryInterface')
        ->ignoring('Modules/*/Tests');
});

// Controllers should never use models directly
it('ensures API controllers do not use Eloquent models directly', function () {
    arch()
        ->expect('Modules/*/Infrastructure/Http/Controllers')
        ->not->toUse('Modules/*/Domain/Models')
        ->ignoring('Modules/*/Tests');
});

// Resources should be used in API controllers for responses
it('ensures API controllers use resources for responses', function () {
    arch()
        ->expect('Modules/*/Infrastructure/Http/Resources')
        ->toBeClasses()
        ->toBeUsedIn('Modules/*/Infrastructure/Http/Controllers')
        ->ignoring('Modules/*/Tests');
});

// API controllers should use Request classes for validation
it('ensures API controllers use request classes for validation', function () {
    arch()
        ->expect('Modules/*/Infrastructure/Http/Requests')
        ->toBeClasses()
        ->toBeUsedIn('Modules/*/Infrastructure/Http/Controllers')
        ->ignoring('Modules/*/Tests');
});
