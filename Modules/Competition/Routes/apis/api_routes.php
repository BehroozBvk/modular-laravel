<?php

use Illuminate\Support\Facades\Route;
use Modules\Competition\Http\Controllers\Api\V1\Competition\ListCompetitionsController;

Route::middleware([])
    ->prefix('v1')
    ->as('v1.')
    ->group(function () {
        Route::prefix('competition')
            ->as('competition.')
            ->group(function () {
                Route::get('/', ListCompetitionsController::class)->name('index');
            });
    });
