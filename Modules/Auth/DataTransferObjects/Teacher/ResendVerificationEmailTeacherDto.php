<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Teacher;

use Modules\Shared\ValueObjects\Email;

final readonly class ResendVerificationEmailTeacherDto
{
    public function __construct(
        public Email $email
    ) {}

    public function toArray(): array
    {
        return [
            'email' => (string) $this->email,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new Email($data['email'])
        );
    }
}
