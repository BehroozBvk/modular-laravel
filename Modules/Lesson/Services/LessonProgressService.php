<?php

declare(strict_types=1);

namespace Modules\Lesson\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Interfaces\Repositories\LessonProgressRepositoryInterface;
use Modules\Lesson\Models\LessonProgress;

final class LessonProgressService
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository
    ) {}

    /**
     * Get a paginated list of lesson progress records based on filters.
     */
    public function getProgressRecords(ListLessonProgressDto $dto): LengthAwarePaginator
    {
        return $this->progressRepository->paginate($dto);
    }

    /**
     * Find a specific progress record by ID.
     */
    public function findProgressRecord(int $id): ?LessonProgress
    {
        return $this->progressRepository->findById($id);
    }

    /**
     * Create a new progress record.
     *
     * @throws Exception
     */
    public function createProgressRecord(CreateLessonProgressDto $dto): LessonProgress
    {
        try {
            return DB::transaction(function () use ($dto) {
                return $this->progressRepository->create($dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to create progress record: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing progress record.
     *
     * @throws Exception
     */
    public function updateProgressRecord(int $id, UpdateLessonProgressDto $dto): bool
    {
        try {
            return DB::transaction(function () use ($id, $dto) {
                return $this->progressRepository->update($id, $dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update progress record: ' . $e->getMessage());
        }
    }

    /**
     * Delete a progress record.
     *
     * @throws Exception
     */
    public function deleteProgressRecord(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->progressRepository->delete($id);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to delete progress record: ' . $e->getMessage());
        }
    }

    /**
     * Get all progress records for a specific lesson.
     */
    public function getProgressByLessonId(int $lessonId): array
    {
        return $this->progressRepository->getByLessonId($lessonId);
    }
}
