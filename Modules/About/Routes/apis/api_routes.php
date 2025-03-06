<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\Api\V1\GetAboutDataController;

Route::prefix('v1')->as('v1.')->group(function () {

    Route::prefix('abouts')
        ->as('abouts.')
        ->group(function () {
            Route::get('/', GetAboutDataController::class)->name('index');
        });
});
