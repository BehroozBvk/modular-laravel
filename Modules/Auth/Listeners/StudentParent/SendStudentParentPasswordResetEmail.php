<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\StudentParent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\StudentParent\StudentParentPasswordResetRequested;
use Modules\Auth\Mail\StudentParent\StudentParentPasswordResetMail;

class SendStudentParentPasswordResetEmail implements ShouldQueue
{
    public function handle(StudentParentPasswordResetRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new StudentParentPasswordResetMail($event->user, $event->token));
    }
}
