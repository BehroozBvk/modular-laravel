<?php

declare(strict_types=1);

namespace Modules\User\DataTransferObjects;

use Modules\Shared\ValueObjects\Email;
use Modules\User\Enums\UserTypeEnum;

final class CreateUserDto
{
    public function __construct(
        public readonly string $name,
        public readonly Email $email,
        public readonly string $password,
        public readonly UserTypeEnum $type
    ) {}

    /**
     * Convert to array for database insertion
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => (string) $this->email,
            'password' => $this->password,
            'type' => $this->type->value,
        ];
    }
}
