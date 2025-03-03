<?php

declare(strict_types=1);

// Domain models should be properly structured
it('ensures domain models are properly structured', function () {
    // All models should extend Eloquent Model or implement custom interfaces
    arch()
        ->expect('Modules\*\Domain\Models')
        ->toBeClasses()
        ->toExtend('Illuminate\Database\Eloquent\Model');

    // Domain model methods should be properly documented
    arch()
        ->expect('Modules\*\Domain\Models')
        ->toHaveMethodsDocumented()
        ->toHavePropertiesDocumented();
});

// Domain enums should be properly structured
it('ensures enums are properly defined', function () {
    arch()
        ->expect('Modules\*\Domain\Enums')
        ->toBeEnums();
});

// Value objects should be immutable
it('ensures value objects are immutable', function () {
    arch()
        ->expect('Modules\*\Domain\ValueObjects')
        ->toBeClasses()
        ->toBeFinal()
        ->toBeReadonly()
        ->toHaveConstructor();
});

// Repository interfaces should be in the Application layer
it('ensures repository interfaces are properly structured', function () {
    arch()
        ->expect('Modules\*\Application\Repositories')
        ->toBeInterfaces()
        ->toHaveSuffix('RepositoryInterface');
});

// Events should be in the domain layer
it('ensures events are properly structured', function () {
    arch()
        ->expect('Modules\*\Domain\Events')
        ->toBeClasses()
        ->toBeFinal();
});
