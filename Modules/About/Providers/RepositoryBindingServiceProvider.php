<?php

declare(strict_types=1);

namespace Modules\About\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;
use Modules\About\Repositories\EloquentAboutIntroRepository;
use Modules\About\Repositories\EloquentAboutPartnerRepository;
use Modules\About\Repositories\EloquentAboutSectionRepository;
use Modules\About\Repositories\EloquentAboutTeamMemberRepository;
use Modules\About\Repositories\EloquentAboutTeamSettingRepository;

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
            AboutIntroRepositoryInterface::class,
            EloquentAboutIntroRepository::class
        );

        $this->app->bind(
            AboutSectionRepositoryInterface::class,
            EloquentAboutSectionRepository::class
        );

        $this->app->bind(
            AboutTeamSettingRepositoryInterface::class,
            EloquentAboutTeamSettingRepository::class
        );

        $this->app->bind(
            AboutTeamMemberRepositoryInterface::class,
            EloquentAboutTeamMemberRepository::class
        );

        $this->app->bind(
            AboutPartnerRepositoryInterface::class,
            EloquentAboutPartnerRepository::class
        );
    }
}
