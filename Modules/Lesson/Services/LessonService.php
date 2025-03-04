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

final class LessonService
{
    public function __construct(
        private readonly LessonRepositoryInterface $lessonRepository
    ) {}

    /**
     * Get a paginated list of lessons based on filters.
     */
    public function getLessons(ListLessonsDto $dto): LengthAwarePaginator
    {
        return $this->lessonRepository->paginate($dto);
    }

    /**
     * Find a specific lesson by ID.
     */
    public function findLesson(int $id): ?Lesson
    {
        return $this->lessonRepository->findById($id);
    }

    /**
     * Create a new lesson.
     *
     * @throws Exception
     */
    public function createLesson(CreateLessonDto $dto): Lesson
    {
        try {
            return DB::transaction(function () use ($dto) {
                return $this->lessonRepository->create($dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to create lesson: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing lesson.
     *
     * @throws Exception
     */
    public function updateLesson(int $id, UpdateLessonDto $dto): bool
    {
        try {
            return DB::transaction(function () use ($id, $dto) {
                return $this->lessonRepository->update($id, $dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update lesson: ' . $e->getMessage());
        }
    }

    /**
     * Delete a lesson.
     *
     * @throws Exception
     */
    public function deleteLesson(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->lessonRepository->delete($id);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to delete lesson: ' . $e->getMessage());
        }
    }
}
