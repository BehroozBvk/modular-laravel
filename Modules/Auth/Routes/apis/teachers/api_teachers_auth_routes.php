<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\ForgotPasswordTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\LoginTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\LogoutTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\RegisterTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\ResendVerificationEmailTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\ResetPasswordTeacherController;
use Modules\Auth\Http\Controllers\Api\V1\Teacher\VerifyEmailTeacherController;

Route::prefix('v1/auth/teachers')->as('v1.auth.teachers.')->group(function () {
    // Public routes
    Route::post('register', RegisterTeacherController::class)->name('register');
    Route::post('login', LoginTeacherController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordTeacherController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordTeacherController::class)->name('reset-password');
    Route::post('verify-email/{id}/{hash}', VerifyEmailTeacherController::class)->name('verify-email');
    Route::post('resend-verification-email', ResendVerificationEmailTeacherController::class)->name('resend-verification-email');

    // Protected routes
    Route::middleware(['auth:user-api', 'user.type:teacher'])->group(function () {
        Route::post('logout', LogoutTeacherController::class)->name('logout');
    });
});
