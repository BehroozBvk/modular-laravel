<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\{
    RegisterParentController,
    LoginParentController,
    LogoutParentController,
    ForgotPasswordParentController,
    ResetPasswordParentController,
    VerifyEmailParentController,
    ResendVerificationEmailParentController
};

Route::prefix('v1/auth/student-parents')->as('v1.auth.student-parents.')->group(function () {
    // Public routes
    Route::post('register', RegisterParentController::class)->name('register');
    Route::post('login', LoginParentController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordParentController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordParentController::class)->name('reset-password');
    Route::post('verify-email/{id}/{hash}', VerifyEmailParentController::class)->name('verify-email');
    Route::post('resend-verification-email', ResendVerificationEmailParentController::class)->name('resend-verification-email');

    // Protected routes
    Route::middleware(['auth:user-api', 'user.type:student_parent'])->group(function () {
        Route::post('logout', LogoutParentController::class)->name('logout');
    });
});
