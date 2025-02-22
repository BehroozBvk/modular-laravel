<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\Student\RegisterStudentController;


Route::middleware(['auth:user-api'])->prefix('v1/auth')->as('v1.auth.')->group(function () {

    Route::prefix('students')->as('students.')->group(function () {
        Route::post('register', RegisterStudentController::class)->name('register');
    });
});
