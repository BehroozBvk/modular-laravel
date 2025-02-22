<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Api\V1\Admin\GetAdminsController;

Route::middleware(['api'])->prefix('v1/admins')->as('v1.admins.')->group(function () {
    Route::get('/', GetAdminsController::class)->name('index');
});
