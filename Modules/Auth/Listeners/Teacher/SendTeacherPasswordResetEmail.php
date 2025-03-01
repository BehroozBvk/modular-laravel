<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Teacher;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Mail\Teacher\TeacherPasswordResetMail;
use Modules\Auth\Events\Teacher\TeacherPasswordResetRequested;

class SendTeacherPasswordResetEmail implements ShouldQueue
{
    public function handle(TeacherPasswordResetRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new TeacherPasswordResetMail($event->user, $event->token));
    }
}
