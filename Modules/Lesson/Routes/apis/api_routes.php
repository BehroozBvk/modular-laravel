<?php

use Illuminate\Support\Facades\Route;
use Modules\Lesson\Http\Controllers\Api\V1\Lesson\CreateLessonController;
use Modules\Lesson\Http\Controllers\Api\V1\Lesson\DeleteLessonController;
use Modules\Lesson\Http\Controllers\Api\V1\Lesson\GetLessonController;
use Modules\Lesson\Http\Controllers\Api\V1\Lesson\ListLessonsController;
use Modules\Lesson\Http\Controllers\Api\V1\Lesson\UpdateLessonController;
use Modules\Lesson\Http\Controllers\Api\V1\Progress\CreateProgressController;
use Modules\Lesson\Http\Controllers\Api\V1\Progress\DeleteProgressController;
use Modules\Lesson\Http\Controllers\Api\V1\Progress\GetProgressController;
use Modules\Lesson\Http\Controllers\Api\V1\Progress\ListProgressController;
use Modules\Lesson\Http\Controllers\Api\V1\Progress\UpdateProgressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // Lesson routes
    Route::prefix('lessons')->group(function () {
        Route::get('/', ListLessonsController::class)->name('lessons.index');
        Route::post('/', CreateLessonController::class)->name('lessons.store');
        Route::get('/{id}', GetLessonController::class)->name('lessons.show');
        Route::put('/{id}', UpdateLessonController::class)->name('lessons.update');
        Route::delete('/{id}', DeleteLessonController::class)->name('lessons.destroy');
    });

    // Lesson Progress routes
    Route::prefix('lesson-progress')->group(function () {
        Route::get('/', ListProgressController::class)->name('lesson-progress.index');
        Route::post('/', CreateProgressController::class)->name('lesson-progress.store');
        Route::get('/{id}', GetProgressController::class)->name('lesson-progress.show');
        Route::put('/{id}', UpdateProgressController::class)->name('lesson-progress.update');
        Route::delete('/{id}', DeleteProgressController::class)->name('lesson-progress.destroy');
    });
});
