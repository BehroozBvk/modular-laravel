<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Teacher;

use Modules\User\Models\User;

final readonly class TeacherEmailVerificationRequested
{
    public function __construct(
        public User $teacher
    ) {}
}
