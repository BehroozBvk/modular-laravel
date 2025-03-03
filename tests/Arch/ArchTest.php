<?php

declare(strict_types=1);

use Modules\Admin\Models\Admin;

// Set global presets
arch()->preset()->laravel();

// General code quality rules
test('application maintains high code quality', function () {
    expect(['App', 'Modules'])
        ->toUseStrictTypes()
        ->not->toUse(['die', 'dd', 'dump', 'var_dump']);
});

// Layer dependencies
test('domain layer does not depend on infrastructure', function () {
    expect(['App\Domain', 'Modules\*\Domain'])
        ->not->toUse(['App\Infrastructure', 'Modules\*\Infrastructure']);
});

// Controller structure
test('controllers follow structural rules', function () {
    expect(['App\Http\Controllers', 'Modules\*\Http\Controllers'])
        ->toHaveNameMatching('*Controller')
        ->toImplement('App\Http\Controllers\Controller');
});

// Repository pattern
test('repositories implement interfaces', function () {
    expect(['App\Infrastructure\Repositories', 'Modules\*\Infrastructure\Repositories'])
        ->toHaveNameMatching('*Repository')
        ->toImplement(['App\Application\Repositories\*RepositoryInterface', 'Modules\*\Application\Repositories\*RepositoryInterface']);
});

// Module namespace validation
test('modules have correct namespaces', function () {
    // Manual check for Admin model namespace
    $adminNamespace = (new \ReflectionClass(Admin::class))->getNamespaceName();
    expect($adminNamespace)->toContain('Admin');
});
