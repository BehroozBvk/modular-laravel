<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\Admin\ForgotPasswordAdminController;
use Modules\Auth\Http\Controllers\Api\V1\Admin\LoginAdminController;
use Modules\Auth\Http\Controllers\Api\V1\Admin\LogoutAdminController;
use Modules\Auth\Http\Controllers\Api\V1\Admin\ResendVerificationEmailAdminController;
use Modules\Auth\Http\Controllers\Api\V1\Admin\ResetPasswordAdminController;
use Modules\Auth\Http\Controllers\Api\V1\Admin\VerifyEmailAdminController;

Route::prefix('v1/auth/admins')->as('v1.auth.admins.')->group(function () {
    // Public routes
    Route::post('login', LoginAdminController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordAdminController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordAdminController::class)->name('reset-password');
    Route::post('verify-email/{id}/{hash}', VerifyEmailAdminController::class)->name('verify-email');
    Route::post('resend-verification-email', ResendVerificationEmailAdminController::class)->name('resend-verification-email');

    // Protected routes
    Route::middleware(['auth:admin-api'])->group(function () {
        Route::post('logout', LogoutAdminController::class)->name('logout');
    });
});
