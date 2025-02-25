<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Student;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Mail\StudentPasswordResetMail;
use Modules\Auth\Events\Student\StudentPasswordResetRequested;

class SendStudentPasswordResetEmail implements ShouldQueue
{
    public function handle(StudentPasswordResetRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new StudentPasswordResetMail($event->user, $event->token));
    }
}
