<?php

declare(strict_types=1);

namespace Modules\Auth\Providers\Student;

use Modules\Auth\Events\Student\StudentPasswordResetRequested;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Modules\Auth\Listeners\Student\SendStudentPasswordResetEmail;

class StudentEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        StudentPasswordResetRequested::class => [
            SendStudentPasswordResetEmail::class,
        ],
    ];
}
