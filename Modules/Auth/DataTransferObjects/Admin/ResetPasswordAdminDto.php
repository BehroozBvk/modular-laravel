<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Admin;

use Modules\User\ValueObjects\Email;

final readonly class ResetPasswordAdminDto
{
    public function __construct(
        public Email $email,
        public string $token,
        public string $password
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: new Email($data['email']),
            token: $data['token'],
            password: $data['password']
        );
    }

    public function toArray(): array
    {
        return [
            'email' => (string) $this->email,
            'token' => $this->token,
            'password' => $this->password,
        ];
    }
}
