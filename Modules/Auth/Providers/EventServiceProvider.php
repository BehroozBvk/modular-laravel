<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Auth\Events\Teacher\TeacherEmailVerificationRequested;
use Modules\Auth\Events\Teacher\TeacherEmailVerified;
use Modules\Auth\Events\Teacher\TeacherPasswordResetRequested;
use Modules\Auth\Listeners\Teacher\SendTeacherPasswordResetEmail;
use Modules\Auth\Listeners\Teacher\TeacherEmailVerificationRequestedListener;
use Modules\Auth\Listeners\Teacher\TeacherEmailVerifiedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        TeacherEmailVerificationRequested::class => [
            TeacherEmailVerificationRequestedListener::class,
        ],
        TeacherEmailVerified::class => [
            TeacherEmailVerifiedListener::class,
        ],
        TeacherPasswordResetRequested::class => [
            SendTeacherPasswordResetEmail::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
