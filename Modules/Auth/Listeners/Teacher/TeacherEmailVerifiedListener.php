<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Teacher;

use Modules\Auth\Events\Teacher\TeacherEmailVerified;

final class TeacherEmailVerifiedListener
{
    public function handle(TeacherEmailVerified $event): void
    {
        // Logic to handle when a teacher's email is verified
        // This could include sending a welcome email, notifying admins, etc.
    }
}
