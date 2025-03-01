<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Api\V1\Admin\ListAdminsController;

Route::middleware(['api'])->prefix('v1/admins')->as('v1.admins.')->group(function () {
    Route::get('/', ListAdminsController::class)->name('index');
});
