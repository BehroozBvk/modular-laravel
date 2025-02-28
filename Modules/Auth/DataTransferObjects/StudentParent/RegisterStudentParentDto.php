<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\StudentParent;

use Modules\Shared\ValueObjects\Email;
use Modules\User\Enums\UserTypeEnum;

final class RegisterStudentParentDto
{
    public function __construct(
        public readonly string $name,
        public readonly Email $email,
        public readonly string $password,
        public readonly ?string $phoneNumber = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $avatar = null,
        public readonly ?int $countryId = null,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email->__toString(),
            'password' => $this->password,
            'phone_number' => $this->phoneNumber,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'avatar' => $this->avatar,
            'country_id' => $this->countryId,
            'type' => UserTypeEnum::STUDENT->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: new Email($data['email']),
            password: $data['password'],
            phoneNumber: $data['phone_number'] ?? null,
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            avatar: $data['avatar'] ?? null,
            countryId: $data['country_id'] ?? null,
        );
    }
}
