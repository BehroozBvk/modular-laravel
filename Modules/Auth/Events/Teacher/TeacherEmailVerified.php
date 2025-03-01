<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Teacher;

use Modules\User\Models\User;

final readonly class TeacherEmailVerified
{
    public function __construct(
        public User $teacher
    ) {}
}
