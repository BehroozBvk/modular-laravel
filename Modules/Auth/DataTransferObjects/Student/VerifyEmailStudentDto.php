<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Student;

final readonly class VerifyEmailStudentDto
{
    public function __construct(
        public int $userId,
        public string $hash
    ) {}

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'hash' => $this->hash,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['userId'],
            hash: $data['hash']
        );
    }
}
