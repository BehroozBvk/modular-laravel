<?php

declare(strict_types=1);

namespace Modules\Auth\DataTransferObjects\Student;

use Modules\Shared\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;
use Modules\User\Enums\UserTypeEnum;

final class RegisterStudentDto
{
    public function __construct(
        public readonly Email $email,
        public readonly string $password,
        public readonly int $studentParentId,
        public readonly ?string $phoneNumber = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $zip = null,
        public readonly ?string $avatar = null,
        public readonly ?int $countryId = null
    ) {}

    /**
     * Convert to CreateUserDto for user creation
     */
    public function toCreateUserDto(): CreateUserDto
    {
        $name = $this->firstName && $this->lastName
            ? "{$this->firstName} {$this->lastName}"
            : "Student " . substr((string)$this->email, 0, strpos((string)$this->email, '@'));

        return new CreateUserDto(
            name: $name,
            email: $this->email,
            password: $this->password,
            type: UserTypeEnum::STUDENT
        );
    }

    /**
     * Get student specific data as array
     * 
     * @return array<string, mixed>
     */
    public function toStudentArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'student_parent_id' => $this->studentParentId,
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
            studentParentId: $data['student_parent_id'],
            phoneNumber: $data['phone_number'] ?? null,
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            zip: $data['zip'] ?? null,
            avatar: $data['avatar'] ?? null,
            countryId: $data['country_id'] ?? null,
        );
    }
}
