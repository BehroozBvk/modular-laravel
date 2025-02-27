<?php

arch()->preset()->Laravel();

arch()->preset()->php();

arch()->preset()->security();

arch()->preset()->strict();

arch()
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toOnlyBeUsedIn('App\Repositories')
    ->ignoring('App\Models\User');

arch()
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch()->preset()->php();
arch()->preset()->security()->ignoring('md5');

arch()->test(
    'Admin model should be in the Admin namespace',
    function () {
        assertModelNamespace(Admin::class, 'Admin');
    }
);
