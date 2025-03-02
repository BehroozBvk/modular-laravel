<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Teacher;

use Modules\Shared\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;
use Modules\User\Enums\UserTypeEnum;

final class RegisterTeacherDto
{
    public function __construct(
        public readonly Email $email,
        public readonly string $password,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $city,
        public readonly string $state,
        public readonly string $zip,
        public readonly int $countryId,
    ) {}

    /**
     * Create a CreateUserDto from this DTO
     */
    public function toCreateUserDto(): CreateUserDto
    {
        return new CreateUserDto(
            name: "{$this->firstName} {$this->lastName}",
            email: $this->email,
            password: $this->password,
            type: UserTypeEnum::TEACHER
        );
    }

    /**
     * Get teacher-specific data as array
     *
     * @return array<string, mixed>
     */
    public function toTeacherArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country_id' => $this->countryId,
        ];
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: new Email($data['email']),
            password: $data['password'],
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            phone: $data['phone'],
            address: $data['address'],
            city: $data['city'],
            state: $data['state'],
            zip: $data['zip'],
            countryId: (int) $data['country_id'],
        );
    }
}
