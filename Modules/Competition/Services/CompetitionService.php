<?php

declare(strict_types=1);

namespace Modules\Competition\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Competition\Interfaces\Repositories\CompetitionRepositoryInterface;
use Modules\Competition\Models\Competition;

final class CompetitionService
{
    public function __construct(
        private readonly CompetitionRepositoryInterface $competitionRepository,
    ) {}

    /**
     * Get paginated list of competitions.
     */
    public function getPaginatedCompetitions(int $perPage = 15): LengthAwarePaginator
    {
        return $this->competitionRepository->paginate($perPage);
    }

    /**
     * Find a competition by ID.
     */
    public function findById(int $id): ?Competition
    {
        return $this->competitionRepository->findById($id);
    }

    /**
     * Find a competition by ID or throw an exception.
     */
    public function findOrFail(int $id): Competition
    {
        return $this->competitionRepository->findOrFail($id);
    }
}
