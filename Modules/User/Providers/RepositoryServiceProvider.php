<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Repositories\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: UserRepositoryInterface::class,
            concrete: EloquentUserRepository::class
        );
    }
}
