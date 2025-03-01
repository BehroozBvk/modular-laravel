<?php

declare(strict_types=1);

namespace Modules\Country\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Country\Interfaces\Repositories\CountryRepositoryInterface;
use Modules\Country\Repositories\EloquentCountryRepository;

final class CountryRepositoryBindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class, EloquentCountryRepository::class);
    }
}
