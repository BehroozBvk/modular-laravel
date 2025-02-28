<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Admin;

final class ChangePasswordAdminDto
{
    public function __construct(
        public readonly int $adminId,
        public readonly string $currentPassword,
        public readonly string $newPassword
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            adminId: $data['admin_id'],
            currentPassword: $data['current_password'],
            newPassword: $data['password']
        );
    }
}
