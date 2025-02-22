<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->runPailCommandIfApplicable();
    }

    /**
     * Run the pail command with a timeout if the application is running in the console,
     * in a local environment, and not on a Windows OS.
     */
    protected function runPailCommandIfApplicable(): void
    {
        if (app()->runningInConsole() && app()->environment('local') && strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            Artisan::call('pail', ['--timeout' => 0]);
        }
    }
}
