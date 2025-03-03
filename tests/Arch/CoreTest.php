<?php

declare(strict_types=1);

// Global presets for code quality and security
arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();

// Ensure strict types are used throughout the application
it('uses strict types throughout the application', function () {
    arch()
        ->expect('App')
        ->toUseStrictTypes();

    arch()
        ->expect('Modules')
        ->toUseStrictTypes();
});

// No debugging functions should be present in the codebase
it('does not allow debugging statements', function () {
    arch()
        ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
        ->not->toBeUsed();
});

// All files should use strict equality to prevent type juggling issues
it('uses strict equality comparison', function () {
    arch()
        ->expect(['App', 'Modules'])
        ->toUseStrictEquality();
});

// Ensure no insecure functions are used
it('does not use insecure functions', function () {
    arch()
        ->expect(['eval', 'shell_exec', 'system', 'passthru', 'exec'])
        ->not->toBeUsed();
});

// Limit file size to maintain readability
it('ensures files are not too large', function () {
    arch()
        ->expect(['App', 'Modules'])
        ->toHaveLineCountLessThan(300);
});
