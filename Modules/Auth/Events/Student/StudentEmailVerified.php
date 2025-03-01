<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Student;

use Modules\User\Models\User;

final readonly class StudentEmailVerified
{
    public function __construct(
        public User $student
    ) {}
}
