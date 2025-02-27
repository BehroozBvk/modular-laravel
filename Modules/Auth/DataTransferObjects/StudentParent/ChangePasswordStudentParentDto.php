<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\StudentParent;

final class ChangePasswordStudentParentDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $currentPassword,
        public readonly string $newPassword
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            currentPassword: $data['current_password'],
            newPassword: $data['password']
        );
    }
}
