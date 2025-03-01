<?php

declare(strict_types=1);

namespace Modules\Country\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Country\DataTransferObjects\CreateCountryDto;
use Modules\Country\DataTransferObjects\ListCountriesDto;
use Modules\Country\DataTransferObjects\UpdateCountryDto;
use Modules\Country\Interfaces\Repositories\CountryRepositoryInterface;
use Modules\Country\Models\Country;

final class CountryService
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    ) {}

    public function getCountries(ListCountriesDto $dto): LengthAwarePaginator
    {
        return $this->countryRepository->paginate($dto);
    }

    public function findCountry(int $id): ?Country
    {
        return $this->countryRepository->findById($id);
    }

    public function createCountry(CreateCountryDto $dto): Country
    {
        return $this->countryRepository->create($dto);
    }

    public function updateCountry(int $id, UpdateCountryDto $dto): bool
    {
        return $this->countryRepository->update($id, $dto);
    }

    public function deleteCountry(int $id): bool
    {
        return $this->countryRepository->delete($id);
    }
}
