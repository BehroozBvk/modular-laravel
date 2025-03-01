<?php

declare(strict_types=1);

namespace Modules\Country\Services;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Modules\Country\ValueObjects\CountriesApiConfig;
use Modules\Country\ValueObjects\CountryData;

final class CountriesApiService
{
    private readonly PendingRequest $client;
    private readonly CountriesApiConfig $config;

    public function __construct()
    {
        $this->config = CountriesApiConfig::fromConfig();
        $this->client = Http::withoutVerifying()
            ->timeout($this->config->timeout)
            ->retry(
                times: $this->config->retryTimes,
                sleepMilliseconds: $this->config->retrySleep,
                when: static fn(Exception $e) => $e->getCode() >= 500
            );
    }

    /**
     * Fetch all countries from the API
     *
     * @return Collection<int, CountryData>
     *
     * @throws Exception
     */
    public function fetchCountries(): Collection
    {
        $response = $this->client->get(
            "{$this->config->baseUrl}/all",
            ['fields' => $this->config->fields]
        );

        if (! $response->successful()) {
            throw new Exception("Failed to fetch countries: {$response->body()}");
        }

        return collect($response->json())
            ->map(fn(array $country): CountryData => CountryData::fromApiResponse($country))
            ->reject(fn(CountryData $country): bool => $country->shouldBeExcluded());
    }

    /**
     * Get the chunk size for database inserts
     */
    public function getChunkSize(): int
    {
        
        return $this->config->chunkSize;
    }
}
