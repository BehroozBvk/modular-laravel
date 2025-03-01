<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Admin;

final readonly class VerifyEmailAdminDto
{
    public function __construct(
        public int $adminId,
        public string $hash,
        public string $signature,
        public int $expires
    ) {}

    public function toArray(): array
    {
        return [
            'adminId' => $this->adminId,
            'hash' => $this->hash,
            'signature' => $this->signature,
            'expires' => $this->expires,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            adminId: $data['adminId'],
            hash: $data['hash'],
            signature: $data['signature'],
            expires: $data['expires']
        );
    }
}
