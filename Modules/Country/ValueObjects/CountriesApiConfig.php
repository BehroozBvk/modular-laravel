<?php

declare(strict_types=1);

namespace Modules\Country\ValueObjects;

use InvalidArgumentException;
use Illuminate\Support\Facades\Config;

final readonly class CountriesApiConfig
{
    private function __construct(
        public string $baseUrl,
        public string $fields,
        public int $chunkSize,
        public int $timeout,
        public int $retryTimes,
        public int $retrySleep,
    ) {
        $this->validate();
    }

    /**
     * Create a new instance from the configuration array
     *
     * @throws InvalidArgumentException
     */
    public static function fromConfig(): self
    {
        $config = Config::get('country.api');

        if (! is_array($config)) {
            throw new InvalidArgumentException('Countries API configuration is missing');
        }

        return new self(
            baseUrl: self::validateString($config['base_url'] ?? null, 'base_url'),
            fields: self::validateString($config['fields'] ?? null, 'fields'),
            chunkSize: self::validateInt($config['chunk_size'] ?? null, 'chunk_size', 1),
            timeout: self::validateInt($config['timeout'] ?? null, 'timeout', 1),
            retryTimes: self::validateInt($config['retry_times'] ?? null, 'retry_times', 0),
            retrySleep: self::validateInt($config['retry_sleep'] ?? null, 'retry_sleep', 0),
        );
    }

    /**
     * Validate the configuration values
     *
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (! filter_var($this->baseUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Base URL must be a valid URL');
        }

        if ($this->chunkSize < 1) {
            throw new InvalidArgumentException('Chunk size must be greater than 0');
        }

        if ($this->timeout < 1) {
            throw new InvalidArgumentException('Timeout must be greater than 0');
        }

        if ($this->retryTimes < 0) {
            throw new InvalidArgumentException('Retry times must be 0 or greater');
        }

        if ($this->retrySleep < 0) {
            throw new InvalidArgumentException('Retry sleep must be 0 or greater');
        }
    }

    /**
     * Validate and return a string value
     *
     * @throws InvalidArgumentException
     */
    private static function validateString(mixed $value, string $field): string
    {
        if (! is_string($value) || trim($value) === '') {
            throw new InvalidArgumentException("The {$field} configuration value must be a non-empty string");
        }

        return $value;
    }

    /**
     * Validate and return an integer value
     *
     * @throws InvalidArgumentException
     */
    private static function validateInt(mixed $value, string $field, int $min = 0): int
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException("The {$field} configuration value must be a number");
        }

        $intValue = (int) $value;

        if ($intValue < $min) {
            throw new InvalidArgumentException("The {$field} configuration value must be {$min} or greater");
        }

        return $intValue;
    }
}
