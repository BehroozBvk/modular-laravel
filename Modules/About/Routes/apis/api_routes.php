<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\Api\V1\GetAboutDataController;

Route::middleware([])
    ->prefix('v1/about')
    ->as('v1.about.')
    ->group(function () {
        Route::get('/', GetAboutDataController::class)->name('index');
    });
