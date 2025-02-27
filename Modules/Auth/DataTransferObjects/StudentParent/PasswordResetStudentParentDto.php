<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\StudentParent;

use Modules\User\ValueObjects\Email;

final class PasswordResetStudentParentDto
{
    public function __construct(
        public readonly Email $email,
        public readonly ?string $token = null,
        public readonly ?string $newPassword = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: new Email($data['email']),
            token: $data['token'] ?? null,
            newPassword: $data['password'] ?? null
        );
    }
}
