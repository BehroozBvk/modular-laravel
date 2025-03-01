<?php

declare(strict_types=1);

namespace Modules\Country\ValueObjects;

use InvalidArgumentException;

final readonly class CountryData
{
    private function __construct(
        public string $name,
        public string $code,
        public ?string $flag,
    ) {
        $this->validate();
    }

    /**
     * Create a CountryData instance from API response data
     *
     * @param array{
     *     name: array{common: string},
     *     flags?: array{png?: string}
     * } $apiData
     */
    public static function fromApiResponse(array $apiData): self
    {
        $code = '';
        if (isset($apiData['flags']['png'])) {
            preg_match('/w320\/([a-z]{2})\.png$/', $apiData['flags']['png'], $matches);
            $code = strtoupper($matches[1] ?? '');
        }

        return new self(
            name: $apiData['name']['common'],
            code: $code,
            flag: $apiData['flags']['png'] ?? null,
        );
    }

    /**
     * Convert the value object to an array for database insertion
     *
     * @return array{name: string, code: string, flag: string|null}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'flag' => $this->flag,
        ];
    }

    /**
     * Validate the country data
     *
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Country name cannot be empty');
        }

        if (empty($this->code)) {
            throw new InvalidArgumentException('Country code cannot be empty');
        }

        if (strlen($this->code) !== 2) {
            throw new InvalidArgumentException('Country code must be exactly 2 characters');
        }
    }

    /**
     * Check if this country should be excluded from seeding
     */
    public function shouldBeExcluded(): bool
    {
        return $this->name === 'Israel' && $this->code === 'IL';
    }
}
