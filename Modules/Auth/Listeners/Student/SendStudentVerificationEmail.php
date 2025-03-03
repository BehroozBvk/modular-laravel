<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Student;

use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\Student\StudentEmailVerificationRequested;
use Modules\Auth\Mail\Student\StudentVerificationEmail;

final class SendStudentVerificationEmail
{
    public function handle(StudentEmailVerificationRequested $event): void
    {
        Mail::to($event->student->email)
            ->send(new StudentVerificationEmail($event->student));
    }
}
