<?php

declare(strict_types=1);

namespace Modules\Lesson\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Lesson\Interfaces\Repositories\LessonProgressRepositoryInterface;
use Modules\Lesson\Interfaces\Repositories\LessonRepositoryInterface;
use Modules\Lesson\Repositories\EloquentLessonProgressRepository;
use Modules\Lesson\Repositories\EloquentLessonRepository;

final class RepositoryBindingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(
            LessonRepositoryInterface::class,
            EloquentLessonRepository::class
        );

        $this->app->bind(
            LessonProgressRepositoryInterface::class,
            EloquentLessonProgressRepository::class
        );
    }
}
