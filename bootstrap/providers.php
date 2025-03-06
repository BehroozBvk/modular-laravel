<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Clockwork\Support\Laravel\ClockworkServiceProvider::class,
    // Sentry\SentryLaravel\SentryLaravelServiceProvider::class,
    Opcodes\LogViewer\LogViewerServiceProvider::class,
];
