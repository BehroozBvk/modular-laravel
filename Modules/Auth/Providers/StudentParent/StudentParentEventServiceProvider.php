<?php

declare(strict_types=1);

namespace Modules\Auth\Providers\StudentParent;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Modules\Auth\Events\StudentParent\StudentParentEmailVerificationRequested;
use Modules\Auth\Events\StudentParent\StudentParentEmailVerified;
use Modules\Auth\Events\StudentParent\StudentParentPasswordResetRequested;
use Modules\Auth\Listeners\StudentParent\SendStudentParentPasswordResetEmail;
use Modules\Auth\Listeners\StudentParent\SendStudentParentVerificationEmail;

class StudentParentEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        StudentParentPasswordResetRequested::class => [
            SendStudentParentPasswordResetEmail::class,
        ],
        StudentParentEmailVerificationRequested::class => [
            SendStudentParentVerificationEmail::class,
        ],
        StudentParentEmailVerified::class => [],
    ];
}
