<?php

declare(strict_types=1);

namespace Modules\Auth\Providers\Student;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Modules\Auth\Events\Student\StudentEmailVerificationRequested;
use Modules\Auth\Events\Student\StudentEmailVerified;
use Modules\Auth\Events\Student\StudentPasswordResetRequested;
use Modules\Auth\Listeners\Student\SendStudentPasswordResetEmail;
use Modules\Auth\Listeners\Student\SendStudentVerificationEmail;

class StudentEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        StudentPasswordResetRequested::class => [
            SendStudentPasswordResetEmail::class,
        ],
        StudentEmailVerificationRequested::class => [
            SendStudentVerificationEmail::class,
        ],
        StudentEmailVerified::class => [],
    ];
}
