<?php

declare(strict_types=1);

namespace Modules\Lesson\Interfaces\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Models\LessonProgress;

/**
 * Interface for Lesson Progress Repository
 * 
 * Provides methods for managing lesson progress records.
 */
interface LessonProgressRepositoryInterface
{
    /**
     * Get paginated lesson progress records based on filters.
     *
     * @param ListLessonProgressDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<LessonProgress> Paginated list of lesson progress records.
     */
    public function paginate(ListLessonProgressDto $dto): LengthAwarePaginator;

    /**
     * Find a lesson progress record by its ID.
     *
     * @param int $id The ID of the lesson progress record.
     * @return LessonProgress|null The lesson progress record or null if not found.
     */
    public function findById(int $id): ?LessonProgress;

    /**
     * Find a lesson progress record by its ID or throw an exception if not found.
     *
     * @param int $id The ID of the lesson progress record.
     * @return LessonProgress The lesson progress record.
     * @throws Exception When progress record is not found.
     */
    public function findOrFail(int $id): LessonProgress;

    /**
     * Create a new lesson progress record.
     *
     * @param CreateLessonProgressDto $dto Data transfer object containing the details of the lesson progress to create.
     * @return LessonProgress The created lesson progress record.
     */
    public function create(CreateLessonProgressDto $dto): LessonProgress;

    /**
     * Update an existing lesson progress record.
     *
     * @param int $id The ID of the lesson progress record to update.
     * @param UpdateLessonProgressDto $dto Data transfer object containing the updated details of the lesson progress.
     * @return LessonProgress The updated lesson progress record.
     * @throws Exception When progress record is not found.
     */
    public function update(int $id, UpdateLessonProgressDto $dto): LessonProgress;

    /**
     * Delete a lesson progress record.
     *
     * @param int $id The ID of the lesson progress record to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Get all progress records for a specific lesson.
     *
     * @param int $lessonId The ID of the lesson.
     * @return Collection<int, LessonProgress> Collection of lesson progress records for the specified lesson.
     */
    public function getProgressByLessonId(int $lessonId): Collection;
}
