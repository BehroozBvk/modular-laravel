<?php

declare(strict_types=1);

namespace Modules\Lesson\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;
use Modules\Lesson\Interfaces\Repositories\LessonRepositoryInterface;
use Modules\Lesson\Models\Lesson;

/**
 * Service class for managing lessons.
 * 
 * Provides methods for creating, updating, deleting, and retrieving lessons.
 */
final class LessonService
{
    /**
     * Constructor for LessonService.
     *
     * @param LessonRepositoryInterface $lessonRepository The repository interface for lesson operations.
     */
    public function __construct(
        private readonly LessonRepositoryInterface $lessonRepository
    ) {}

    /**
     * Get a paginated list of lessons based on filters.
     *
     * @param ListLessonsDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Lesson> Paginated list of lessons.
     */
    public function getLessons(ListLessonsDto $dto): LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($dto);
    }

    /**
     * Find a specific lesson by ID.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson|null The lesson or null if not found.
     */
    public function findLesson(int $id): ?Lesson
    {
        return $this->lessonRepository->findById($id);
    }

    /**
     * Find a specific lesson by ID or throw an exception if not found.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson The lesson.
     * @throws Exception When lesson is not found.
     */
    public function findLessonOrFail(int $id): Lesson
    {
        return $this->lessonRepository->findOrFail($id);
    }

    /**
     * Create a new lesson.
     *
     * @param CreateLessonDto $dto Data transfer object containing the details of the lesson to create.
     * @return Lesson The created lesson.
     * @throws Exception When lesson creation fails.
     */
    public function createLesson(CreateLessonDto $dto): Lesson
    {
        try {
            return DB::transaction(function () use ($dto): Lesson {
                return $this->lessonRepository->create($dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to create lesson: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing lesson.
     *
     * @param int $id The ID of the lesson to update.
     * @param UpdateLessonDto $dto Data transfer object containing the updated details of the lesson.
     * @return Lesson The updated lesson.
     * @throws Exception When lesson update fails.
     */
    public function updateLesson(int $id, UpdateLessonDto $dto): Lesson
    {
        try {
            return DB::transaction(function () use ($id, $dto): Lesson {
                $lesson = $this->lessonRepository->update($id, $dto);
                $lesson->load('progress');
                return $lesson;
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update lesson: ' . $e->getMessage());
        }
    }

    /**
     * Delete a lesson.
     *
     * @param int $id The ID of the lesson to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When lesson is not found or deletion fails.
     */
    public function deleteLesson(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id): bool {
                return $this->lessonRepository->deleteLessonById($id);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to delete lesson: ' . $e->getMessage());
        }
    }
}
