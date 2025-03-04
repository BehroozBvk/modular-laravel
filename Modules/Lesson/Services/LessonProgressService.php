<?php

declare(strict_types=1);

namespace Modules\Lesson\Services;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Interfaces\Repositories\LessonProgressRepositoryInterface;
use Modules\Lesson\Models\LessonProgress;

/**
 * Service class for managing lesson progress records.
 */
final class LessonProgressService
{
    /**
     * Constructor for LessonProgressService.
     *
     * @param LessonProgressRepositoryInterface $progressRepository Repository interface for lesson progress.
     */
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository
    ) {}

    /**
     * Get a paginated list of lesson progress records based on filters.
     *
     * @param ListLessonProgressDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<LessonProgress> Paginated list of lesson progress records.
     */
    public function getProgressRecords(ListLessonProgressDto $dto): LengthAwarePaginator
    {
        return $this->progressRepository->paginate($dto);
    }

    /**
     * Find a specific progress record by ID.
     *
     * @param int $id The ID of the lesson progress record.
     * @return LessonProgress|null The lesson progress record or null if not found.
     */
    public function findProgressRecord(int $id): ?LessonProgress
    {
        return $this->progressRepository->findById($id);
    }

    /**
     * Create a new progress record.
     *
     * @param CreateLessonProgressDto $dto Data transfer object containing the details of the lesson progress to create.
     * @return LessonProgress The created lesson progress record.
     * @throws Exception When creation fails.
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
     * @param int $id The ID of the lesson progress record to update.
     * @param UpdateLessonProgressDto $dto Data transfer object containing the updated details of the lesson progress.
     * @return LessonProgress The updated lesson progress record.
     * @throws Exception When update fails.
     */
    public function updateProgressRecord(int $id, UpdateLessonProgressDto $dto): LessonProgress
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
     * @param int $id The ID of the lesson progress record to delete.
     * @return bool True if the deletion was successful, false otherwise.
     * @throws Exception When deletion fails.
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
     *
     * @param int $lessonId The ID of the lesson.
     * @return Collection<int, LessonProgress> Collection of lesson progress records for the specified lesson.
     */
    public function getProgressByLessonId(int $lessonId): Collection
    {
        return $this->progressRepository->getProgressByLessonId($lessonId);
    }
}
