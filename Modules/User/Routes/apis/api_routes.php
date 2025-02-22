<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\V1\GetUserSController;

Route::middleware(['api'])->prefix('v1/users')->as('v1.users.')->group(function () {
    Route::get('/', GetUserSController::class)->name('index');
});
