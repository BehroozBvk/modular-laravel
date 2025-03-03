<?php

declare(strict_types=1);

namespace Modules\Auth\Providers\Teacher;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Modules\Auth\Events\Teacher\TeacherEmailVerificationRequested;
use Modules\Auth\Events\Teacher\TeacherEmailVerified;
use Modules\Auth\Events\Teacher\TeacherPasswordResetRequested;
use Modules\Auth\Listeners\Teacher\SendTeacherPasswordResetEmail;
use Modules\Auth\Listeners\Teacher\TeacherEmailVerificationRequestedListener;
use Modules\Auth\Listeners\Teacher\TeacherEmailVerifiedListener;

class TeacherEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        TeacherPasswordResetRequested::class => [
            SendTeacherPasswordResetEmail::class,
        ],
        TeacherEmailVerificationRequested::class => [
            TeacherEmailVerificationRequestedListener::class,
        ],
        TeacherEmailVerified::class => [
            TeacherEmailVerifiedListener::class,
        ],
    ];
}
