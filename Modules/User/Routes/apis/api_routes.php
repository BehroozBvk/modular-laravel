<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\V1\User\ListUsersController;

Route::middleware(['api'])->prefix('v1/users')->as('v1.users.')->group(function () {
    Route::get('/', ListUsersController::class)->name('index');
});
