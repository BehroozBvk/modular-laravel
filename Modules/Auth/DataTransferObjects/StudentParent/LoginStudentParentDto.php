<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\StudentParent;

use Modules\Shared\ValueObjects\Email;

final readonly class LoginStudentParentDto
{
    public function __construct(
        public Email $email,
        public string $password
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: new Email($data['email']),
            password: $data['password']
        );
    }

    public function toArray(): array
    {
        return [
            'email' => (string) $this->email,
            'password' => $this->password,
        ];
    }
}
