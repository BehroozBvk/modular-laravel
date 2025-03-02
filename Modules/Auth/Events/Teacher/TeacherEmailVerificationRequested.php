<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Teacher;

use Modules\Teacher\Models\Teacher;

final readonly class TeacherEmailVerificationRequested
{
    public function __construct(
        public Teacher $teacher
    ) {}
}
