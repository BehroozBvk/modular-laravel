<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\GetArticleBySlugController;
use Modules\Article\Http\Controllers\ListArticlesController;

/*
|--------------------------------------------------------------------------
| Article API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('articles')->group(function () {
    Route::get('/', ListArticlesController::class);
    Route::get('/{slug}', GetArticleBySlugController::class);
});
