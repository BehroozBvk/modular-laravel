<?php

declare(strict_types=1);

namespace Modules\Teacher\DataTransferObjects;

use Modules\Shared\ValueObjects\Email;

final readonly class CreateTeacherDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $phone,
        public string $address,
        public string $city,
        public string $state,
        public string $zip,
        public int $countryId,
        public ?int $userId = null,
        public ?string $email = null,
        public ?string $password = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            phone: $data['phone_number'],
            address: $data['address'],
            city: $data['city'],
            state: $data['state'],
            zip: $data['zip'],
            countryId: (int) $data['country_id'],
            userId: isset($data['user_id']) ? (int) $data['user_id'] : null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country_id' => $this->countryId,
            'user_id' => $this->userId,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
