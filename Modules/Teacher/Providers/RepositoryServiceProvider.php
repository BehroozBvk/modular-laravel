<?php

declare(strict_types=1);

namespace Modules\Teacher\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Teacher\Repositories\EloquentTeacherRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: TeacherRepositoryInterface::class,
            concrete: EloquentTeacherRepository::class
        );
    }
}
