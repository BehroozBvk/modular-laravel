<?php

declare(strict_types=1);

namespace Modules\StudentParent\DataTransferObjects;

final readonly class UpdateStudentParentDto
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
        ];
    }
}
