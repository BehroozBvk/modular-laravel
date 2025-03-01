<?php

declare(strict_types=1);

namespace Modules\Country\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Country\DataTransferObjects\CreateCountryDto;
use Modules\Country\DataTransferObjects\ListCountriesDto;
use Modules\Country\DataTransferObjects\UpdateCountryDto;
use Modules\Country\Models\Country;

interface CountryRepositoryInterface
{
    /**
     * Get all countries with pagination
     */
    public function paginate(ListCountriesDto $dto): LengthAwarePaginator;

    /**
     * Find a country by ID
     */
    public function findById(int $id): ?Country;

    /**
     * Create a new country
     */
    public function create(CreateCountryDto $dto): Country;

    /**
     * Update a country
     */
    public function update(int $id, UpdateCountryDto $dto): bool;

    /**
     * Delete a country
     */
    public function delete(int $id): bool;
}
