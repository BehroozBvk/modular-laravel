<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\ForgotPasswordStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\LoginStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\LogoutStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\RegisterStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\ResendVerificationEmailStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\ResetPasswordStudentParentController;
use Modules\Auth\Http\Controllers\Api\V1\StudentParent\VerifyEmailStudentParentController;

Route::prefix('v1/auth/student-parents')->as('v1.auth.student-parents.')->group(function () {
    // Public routes
    Route::post('register', RegisterStudentParentController::class)->name('register');
    Route::post('login', LoginStudentParentController::class)->name('login');
    Route::post('forgot-password', ForgotPasswordStudentParentController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordStudentParentController::class)->name('reset-password');
    Route::post('verify-email/{id}/{hash}', VerifyEmailStudentParentController::class)->name('verify-email');
    Route::post('resend-verification-email', ResendVerificationEmailStudentParentController::class)->name('resend-verification-email');

    // Protected routes
    Route::middleware(['auth:user-api', 'user.type:student_parent'])->group(function () {
        Route::post('logout', LogoutStudentParentController::class)->name('logout');
    });
});
