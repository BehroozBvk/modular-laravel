<?php

declare(strict_types=1);

namespace Modules\Country\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Country\DataTransferObjects\CreateCountryDto;
use Modules\Country\DataTransferObjects\ListCountriesDto;
use Modules\Country\DataTransferObjects\UpdateCountryDto;
use Modules\Country\Interfaces\Repositories\CountryRepositoryInterface;
use Modules\Country\Models\Country;

final class EloquentCountryRepository implements CountryRepositoryInterface
{
    public function paginate(ListCountriesDto $dto): LengthAwarePaginator
    {
        return Country::query()
            ->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage);
    }

    public function findById(int $id): ?Country
    {
        return Country::query()->find($id);
    }

    public function create(CreateCountryDto $dto): Country
    {
        return Country::query()->create($dto->toArray());
    }

    public function update(int $id, UpdateCountryDto $dto): bool
    {
        $country = $this->findById($id);

        if (! $country) {
            return false;
        }

        return $country->update($dto->toArray());
    }

    public function delete(int $id): bool
    {
        $country = $this->findById($id);

        if (! $country) {
            return false;
        }

        return $country->delete();
    }
}
