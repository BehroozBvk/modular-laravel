<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Teacher;

use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\Teacher\TeacherEmailVerificationRequested;
use Modules\Auth\Mail\Teacher\TeacherVerificationEmail;

final class TeacherEmailVerificationRequestedListener
{
    public function handle(TeacherEmailVerificationRequested $event): void
    {
        Mail::to($event->teacher->user->email)
            ->send(new TeacherVerificationEmail($event->teacher));
    }
}
