<?php

declare(strict_types=1);

namespace Modules\Lesson\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Interfaces\Repositories\LessonProgressRepositoryInterface;
use Modules\Lesson\Models\LessonProgress;

final class EloquentLessonProgressRepository implements LessonProgressRepositoryInterface
{
    /**
     * Get paginated lesson progress records based on filters.
     */
    public function paginate(ListLessonProgressDto $dto): LengthAwarePaginator
    {
        $query = LessonProgress::query();

        // Apply filters
        if ($dto->lessonId !== null) {
            $query->where('lesson_id', $dto->lessonId);
        }

        if ($dto->studentId !== null) {
            $query->where('student_id', $dto->studentId);
        }

        // Apply sorting
        $query->orderBy($dto->sortBy, $dto->sortDirection);

        return $query->paginate($dto->perPage);
    }

    /**
     * Find a lesson progress record by its ID.
     */
    public function findById(int $id): ?LessonProgress
    {
        return LessonProgress::find($id);
    }

    /**
     * Create a new lesson progress record.
     */
    public function create(CreateLessonProgressDto $dto): LessonProgress
    {
        return LessonProgress::create([
            'lesson_id' => $dto->lessonId,
            'student_id' => $dto->studentId,
            'memorization_level' => $dto->memorizationLevel,
            'recitation_quality' => $dto->recitationQuality,
            'mistakes_count' => $dto->mistakesCount,
            'notes' => $dto->notes,
        ]);
    }

    /**
     * Update an existing lesson progress record.
     */
    public function update(int $id, UpdateLessonProgressDto $dto): bool
    {
        $progress = $this->findById($id);

        if (!$progress) {
            return false;
        }

        return $progress->update($dto->toArray());
    }

    /**
     * Delete a lesson progress record.
     */
    public function delete(int $id): bool
    {
        $progress = $this->findById($id);

        if (!$progress) {
            return false;
        }

        return $progress->delete();
    }

    /**
     * Get all progress records for a specific lesson.
     */
    public function getByLessonId(int $lessonId): array
    {
        return LessonProgress::where('lesson_id', $lessonId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
}
