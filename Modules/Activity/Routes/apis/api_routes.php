<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Activity\Http\Controllers\Api\V1\ListActivitiesController;
use Modules\Activity\Http\Controllers\Api\V1\GetActivityByIdController;
use Modules\Activity\Http\Controllers\Api\V1\GetActivityBySlugController;

Route::prefix('v1')->as('v1.')->group(function () {
    Route::prefix('activities')
        ->as('activities.')
        ->group(function () {
            Route::get('/', ListActivitiesController::class)->name('index');
            Route::get('/{id}', GetActivityByIdController::class)->name('show')->where('id', '[0-9]+');
            Route::get('/slug/{slug}', GetActivityBySlugController::class)->name('show-by-slug')->where('slug', '[a-z0-9-]+');
        });
});
