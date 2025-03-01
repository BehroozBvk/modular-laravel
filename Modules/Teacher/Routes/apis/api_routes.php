<?php

use Illuminate\Support\Facades\Route;
use Modules\Teacher\Http\Controllers\Api\V1\Teacher\ListTeachersController;

Route::middleware([])->prefix('v1/teachers')->as('v1.teachers.')->group(function () {
    Route::get('/', ListTeachersController::class)->name('index');
});
