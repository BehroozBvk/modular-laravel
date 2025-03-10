<?php

declare(strict_types=1);

namespace Modules\Country\DataTransferObjects;

final readonly class ListCountriesDto
{
    public function __construct(
        public int $perPage,
        public string $sortBy,
        public string $sortDirection,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            perPage: (int) ($data['per_page'] ?? 15),
            sortBy: $data['sort_by'] ?? 'created_at',
            sortDirection: strtolower($data['sort_direction'] ?? 'desc'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
            'sort_by' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
        ];
    }
}
