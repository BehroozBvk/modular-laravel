<?php

declare(strict_types=1);

namespace Modules\Lesson\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;
use Modules\Lesson\Interfaces\Repositories\LessonRepositoryInterface;
use Modules\Lesson\Models\Lesson;

/**
 * Eloquent implementation of the LessonRepositoryInterface.
 * 
 * Provides methods for managing lesson records using Eloquent ORM.
 */
final class EloquentLessonRepository implements LessonRepositoryInterface
{
    /**
     * Get paginated lessons based on filters.
     *
     * @param ListLessonsDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Lesson> Paginated list of lessons.
     */
    public function paginate(ListLessonsDto $dto): LengthAwarePaginator
    {
        $query = Lesson::query();

        // Apply filters
        if ($dto->studentId !== null) {
            $query->where('student_id', $dto->studentId);
        }

        if ($dto->teacherId !== null) {
            $query->where('teacher_id', $dto->teacherId);
        }

        if ($dto->date !== null) {
            $query->whereDate('date', $dto->date);
        }

        // Apply sorting
        $query->orderBy($dto->sortBy, $dto->sortDirection);

        return $query->paginate($dto->perPage);
    }

    /**
     * Find a lesson by its ID.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson|null The lesson or null if not found.
     */
    public function findById(int $id): ?Lesson
    {
        return Lesson::find($id);
    }

    /**
     * Find a lesson by its ID or throw an exception if not found.
     *
     * @param int $id The ID of the lesson.
     * @return Lesson The lesson.
     * @throws Exception When lesson is not found.
     */
    public function findOrFail(int $id): Lesson
    {
        return Lesson::findOrFail($id);
    }

    /**
     * Create a new lesson.
     *
     * @param CreateLessonDto $dto Data transfer object containing the details of the lesson to create.
     * @return Lesson The created lesson.
     */
    public function create(CreateLessonDto $dto): Lesson
    {
        return Lesson::create([
            'teacher_id' => $dto->teacherId,
            'student_id' => $dto->studentId,
            'surah' => $dto->surah,
            'ayah_from' => $dto->ayahFrom,
            'ayah_to' => $dto->ayahTo,
            'date' => $dto->date,
            'homework' => $dto->homework,
            'feedback' => $dto->feedback,
        ]);
    }

    /**
     * Update an existing lesson.
     *
     * @param int $id The ID of the lesson to update.
     * @param UpdateLessonDto $dto Data transfer object containing the updated details of the lesson.
     * @return Lesson The updated lesson.
     * @throws Exception When lesson is not found.
     */
    public function update(int $id, UpdateLessonDto $dto): Lesson
    {
        $lesson = $this->findOrFail($id);
        $lesson->update($dto->toArray());

        return $lesson->fresh();
    }

    /**
     * Delete a lesson.
     *
     * @param int $id The ID of the lesson to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When lesson is not found.
     */
    public function deleteLessonById(int $id): bool
    {
        $lesson = $this->findOrFail($id);
        return $lesson->delete();
    }
}
