<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\StudentParent;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Mail\StudentParentPasswordResetMail;
use Modules\Auth\Events\StudentParent\StudentParentPasswordResetRequested;

class SendStudentParentPasswordResetEmail implements ShouldQueue
{
    public function handle(StudentParentPasswordResetRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new StudentParentPasswordResetMail($event->user, $event->token));
    }
}
