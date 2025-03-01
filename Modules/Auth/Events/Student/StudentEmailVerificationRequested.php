<?php

declare(strict_types=1);

namespace Modules\Auth\Events\Student;

use Modules\User\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

final readonly class StudentEmailVerificationRequested
{
    public function __construct(
        public User $student
    ) {}
}
    
