<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Teacher;

final readonly class VerifyEmailTeacherDto
{
    public function __construct(
        public int $id,
        public string $hash
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            hash: $data['hash']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'hash' => $this->hash,
        ];
    }
}
