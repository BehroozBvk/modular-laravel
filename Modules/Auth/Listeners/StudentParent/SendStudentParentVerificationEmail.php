<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\StudentParent;

use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\StudentParent\StudentParentEmailVerificationRequested;
use Modules\Auth\Mail\StudentParent\StudentParentVerificationEmail;

final class SendStudentParentVerificationEmail
{
    public function handle(StudentParentEmailVerificationRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new StudentParentVerificationEmail($event->user));
    }
}
