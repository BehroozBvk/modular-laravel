<?php

declare(strict_types=1);

namespace Modules\Auth\Events\StudentParent;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

final class StudentParentEmailVerificationRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user
    ) {}
}
