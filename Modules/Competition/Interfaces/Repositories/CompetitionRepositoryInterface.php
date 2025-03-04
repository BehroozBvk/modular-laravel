<?php

declare(strict_types=1);

namespace Modules\Competition\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Competition\Models\Competition;

interface CompetitionRepositoryInterface
{
    /**
     * Get paginated list of competitions.
     */
    public function paginate(int $perPage): LengthAwarePaginator;

    /**
     * Find a competition by ID.
     */
    public function findById(int $id): ?Competition;

    /**
     * Find a competition by ID or throw an exception.
     */
    public function findOrFail(int $id): Competition;
}
