<?php

declare(strict_types=1);

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Interfaces\Repositories\AdminRepositoryInterface;
use Modules\Admin\Repositories\EloquentAdminRepository;

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
            AdminRepositoryInterface::class,
            EloquentAdminRepository::class
        );
    }
}
