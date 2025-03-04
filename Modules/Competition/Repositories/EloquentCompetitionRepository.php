<?php

declare(strict_types=1);

namespace Modules\Competition\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Competition\Interfaces\Repositories\CompetitionRepositoryInterface;
use Modules\Competition\Models\Competition;

final class EloquentCompetitionRepository implements CompetitionRepositoryInterface
{
    public function __construct(
        private readonly Competition $competitionModel,
    ) {}

    /**
     * Get paginated list of competitions.
     */
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->competitionModel
            ->with(['translations'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find a competition by ID.
     */
    public function findById(int $id): ?Competition
    {
        return $this->competitionModel
            ->with(['translations'])
            ->find($id);
    }

    /**
     * Find a competition by ID or throw an exception.
     */
    public function findOrFail(int $id): Competition
    {
        return $this->competitionModel
            ->with(['translations'])
            ->findOrFail($id);
    }
}
