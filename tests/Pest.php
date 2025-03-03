<?php

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

use Illuminate\Support\Str;
use PHPUnit\Architecture\Asserts\ArchitectureAsserts;

// Custom helper for asserting model namespace
function assertModelNamespace(string $modelClass, string $expectedNamespace): void
{
    $actualNamespace = Str::of($modelClass)->beforeLast('\\')->toString();
    expect($actualNamespace)->toContain($expectedNamespace);
}

// Custom architecture testing configuration
pest()->beforeEach(function () {
    // Only apply architecture settings to architecture tests
    if ($this instanceof ArchitectureAsserts) {
        $this->arch()->ignore([
            'Tests',
            'Database\Factories',
            'Database\Seeders',
        ])->ignoreGlobalFunctions();
    }
});
