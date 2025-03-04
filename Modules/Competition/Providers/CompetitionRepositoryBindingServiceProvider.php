<?php

declare(strict_types=1);

namespace Modules\Competition\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Competition\Interfaces\Repositories\CompetitionRepositoryInterface;
use Modules\Competition\Repositories\EloquentCompetitionRepository;

final class CompetitionRepositoryBindingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(
            CompetitionRepositoryInterface::class,
            EloquentCompetitionRepository::class
        );
    }
}
