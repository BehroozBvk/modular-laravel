<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Admin;

final readonly class VerifyEmailAdminDto
{
    public function __construct(
        public int $adminId,
        public string $hash
    ) {}

    public function toArray(): array
    {
        return [
            'adminId' => $this->adminId,
            'hash' => $this->hash,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            adminId: $data['adminId'],
            hash: $data['hash']
        );
    }
}
