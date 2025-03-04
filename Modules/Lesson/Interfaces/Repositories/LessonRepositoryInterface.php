<?php

declare(strict_types=1);

namespace Modules\Lesson\Interfaces\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;
use Modules\Lesson\Models\Lesson;

/**
 * Interface for Lesson Repository
 * 
 * Provides methods for managing lesson records.
 */
interface LessonRepositoryInterface
{
    /**
     * Get paginated lessons based on filters.
     *
     * @param ListLessonsDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Lesson> Paginated list of lessons.
     */
    public function paginate(ListLessonsDto $dto): LengthAwarePaginator;

    /**
     * Find a lesson by its ID.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson|null The lesson or null if not found.
     */
    public function findById(int $id): ?Lesson;

    /**
     * Find a lesson by its ID or throw an exception if not found.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson The lesson.
     * @throws Exception When lesson is not found.
     */
    public function findOrFail(int $id): Lesson;

    /**
     * Create a new lesson.
     *
     * @param CreateLessonDto $dto Data transfer object containing the details of the lesson to create.
     * @return Lesson The created lesson.
     */
    public function create(CreateLessonDto $dto): Lesson;

    /**
     * Update an existing lesson.
     *
     * @param int $id The ID of the lesson to update.
     * @param UpdateLessonDto $dto Data transfer object containing the updated details of the lesson.
     * @return Lesson The updated lesson.
     * @throws Exception When lesson is not found.
     */
    public function update(int $id, UpdateLessonDto $dto): Lesson;

    /**
     * Delete a lesson.
     *
     * @param int $id The ID of the lesson to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When lesson is not found.
     */
    public function deleteLessonById(int $id): bool;
}
