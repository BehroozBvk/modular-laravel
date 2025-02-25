<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\Student\{
    RegisterStudentController,
    LoginStudentController,
    LogoutStudentController,
    ForgotPasswordStudentController,
    ResetPasswordStudentController,
    VerifyEmailStudentController,
    ResendVerificationEmailStudentController
};

Route::prefix('v1/auth/students')->as('v1.auth.students.')->group(function () {
    // Public routes
    Route::post('register', RegisterStudentController::class)->name('register');
    Route::post('login', LoginStudentController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordStudentController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordStudentController::class)->name('reset-password');
    Route::post('verify-email/{id}/{hash}', VerifyEmailStudentController::class)->name('verify-email');
    Route::post('resend-verification-email', ResendVerificationEmailStudentController::class)->name('resend-verification-email');

    // Protected routes
    Route::middleware(['auth:user-api', 'user.type:student'])->group(function () {
        Route::post('logout', LogoutStudentController::class)->name('logout');
    });
});
