<?php

it('does not allow debugging statements', function () {
    arch()
        ->expect(['dd', 'dump', 'ray'])
        ->not->toBeUsed();
});

it('ensures API controllers do not use Eloquent models directly', function () {
    arch()
        ->expect('App\Models')
        ->not->toBeUsedIn('App\Http\Controllers\Api');
});

it('uses Query classes appropriately in the Catalog domain', function () {
    arch()
        ->expect('Domains\Catalog\Queries')
        ->toBeUsedIn('App\Http\Controllers\Api\V1\Products\Read');
});
