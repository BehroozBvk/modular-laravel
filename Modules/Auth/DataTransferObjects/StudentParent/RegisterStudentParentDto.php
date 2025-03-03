<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\StudentParent;

use Modules\Shared\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;
use Modules\User\Enums\UserTypeEnum;

final class RegisterStudentParentDto
{
    public function __construct(
        public readonly Email $email,
        public readonly string $password,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $phoneNumber = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $zip = null,
        public readonly ?int $countryId = null,
        public readonly ?string $avatar = null
    ) {}

    /**
     * Convert to CreateUserDto for user creation
     */
    public function toCreateUserDto(): CreateUserDto
    {
        $name = $this->firstName && $this->lastName
            ? "{$this->firstName} {$this->lastName}"
            : "Parent " . substr((string)$this->email, 0, strpos((string)$this->email, '@'));

        return new CreateUserDto(
            name: $name,
            email: $this->email,
            password: $this->password,
            type: UserTypeEnum::STUDENT_PARENT
        );
    }

    /**
     * Get student parent specific data as array
     * 
     * @return array<string, mixed>
     */
    public function toParentArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country_id' => $this->countryId,
        ]);
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
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            phoneNumber: $data['phone_number'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            zip: $data['zip'] ?? null,
            countryId: isset($data['country_id']) ? (int) $data['country_id'] : null,
            avatar: $data['avatar'] ?? null
        );
    }
}
