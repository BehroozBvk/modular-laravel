<?php

declare(strict_types=1);

namespace Modules\Student\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Student\Interfaces\Repositories\StudentRepositoryInterface;
use Modules\Student\Repositories\EloquentStudentRepository;

/**
 * Service provider for registering repository bindings
 */
class RepositoryBindingServiceProvider extends ServiceProvider
{
    /**
     * Register repository bindings
     */
    public function register(): void
    {
        $this->app->bind(
            StudentRepositoryInterface::class,
            EloquentStudentRepository::class
        );
    }
}
