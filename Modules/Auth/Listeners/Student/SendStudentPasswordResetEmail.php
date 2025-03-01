<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Student;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\Student\StudentPasswordResetRequested;
use Modules\Auth\Mail\Student\StudentPasswordResetMail;

class SendStudentPasswordResetEmail implements ShouldQueue
{
    public function handle(StudentPasswordResetRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new StudentPasswordResetMail($event->user, $event->token));
    }
}
