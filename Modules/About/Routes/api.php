<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\Api\V1\GetAboutDataController;

Route::prefix('api/v1')->name('api.v1.')->group(function () {
    Route::get('/about', GetAboutDataController::class)->name('about.index');
});
