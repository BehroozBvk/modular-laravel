<?php

declare(strict_types=1);

namespace Modules\Lesson\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;
use Modules\Lesson\Interfaces\Repositories\LessonRepositoryInterface;
use Modules\Lesson\Models\Lesson;

final class EloquentLessonRepository implements LessonRepositoryInterface
{
    /**
     * Get paginated lessons based on filters.
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
     */
    public function findById(int $id): ?Lesson
    {
        return Lesson::find($id);
    }

    /**
     * Create a new lesson.
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
     */
    public function update(int $id, UpdateLessonDto $dto): bool
    {
        $lesson = $this->findById($id);

        if (!$lesson) {
            return false;
        }

        return $lesson->update($dto->toArray());
    }

    /**
     * Delete a lesson.
     */
    public function delete(int $id): bool
    {
        $lesson = $this->findById($id);

        if (!$lesson) {
            return false;
        }

        return $lesson->delete();
    }
}
