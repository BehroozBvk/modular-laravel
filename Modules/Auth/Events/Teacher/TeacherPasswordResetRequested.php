<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Teacher;

use Modules\User\Models\User;

final readonly class TeacherPasswordResetRequested
{
    public function __construct(
        public User $user,
        public string $token
    ) {}
}
