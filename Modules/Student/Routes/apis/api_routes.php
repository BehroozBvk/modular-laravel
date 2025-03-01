<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\Api\V1\Student\ListStudentsController;


Route::middleware([])->prefix('v1/students')->as('v1.students.')->group(function () {
    Route::get('/', ListStudentsController::class)->name('index');
});
