<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentParent\Http\Controllers\Api\V1\GetStudentParentsController;

Route::middleware([])->prefix('v1/student-parents')->as('v1.studentparents.')->group(function () {
    Route::get('/', GetStudentParentsController::class)->name('index');
});
