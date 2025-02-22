<?php

declare(strict_types=1);

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Country\Http\Controllers\Api\V1\GetCountriesController;

Route::middleware('api')->prefix('v1/countries')->as('v1.countries.')->group(function () {
    Route::get('/', GetCountriesController::class)->name('index');
});
