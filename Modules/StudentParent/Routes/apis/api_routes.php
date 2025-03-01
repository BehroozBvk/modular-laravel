<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentParent\Http\Controllers\Api\V1\StudentParent\ListStudentParentsController;

Route::middleware([])->prefix('v1/student-parents')->as('v1.student-parents.')->group(function () {
    Route::get('/', ListStudentParentsController::class)->name('index');
});
