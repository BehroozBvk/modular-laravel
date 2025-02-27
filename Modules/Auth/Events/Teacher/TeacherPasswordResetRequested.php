<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Teacher;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

class TeacherPasswordResetRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $token
    ) {}
}
