<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1.')->group(function () {
    Route::prefix('articles')
        ->as('articles.')
        ->group(function () {
        });
});