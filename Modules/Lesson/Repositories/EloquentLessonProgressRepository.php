<?php

declare(strict_types=1);

namespace Modules\Lesson\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Interfaces\Repositories\LessonProgressRepositoryInterface;
use Modules\Lesson\Models\LessonProgress;

/**
 * Repository for managing lesson progress records using Eloquent ORM.
 */
final class EloquentLessonProgressRepository implements LessonProgressRepositoryInterface
{
    /**
     * Get paginated lesson progress records based on filters.
     *
     * @param ListLessonProgressDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<LessonProgress> Paginated list of lesson progress records.
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
     *
     * @param int $id The ID of the lesson progress record.
     * @return LessonProgress|null The lesson progress record or null if not found.
     */
    public function findById(int $id): ?LessonProgress
    {
        return LessonProgress::find($id);
    }

    /**
     * Find a lesson progress record by its ID or throw an exception if not found.
     *
     * @param int $id The ID of the lesson progress record.
     * @return LessonProgress The lesson progress record.
     * @throws Exception When progress record is not found.
     */
    public function findOrFail(int $id): LessonProgress
    {
        return LessonProgress::findOrFail($id);
    }

    /**
     * Create a new lesson progress record.
     *
     * @param CreateLessonProgressDto $dto Data transfer object containing the details of the lesson progress to create.
     * @return LessonProgress The created lesson progress record.
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
     *
     * @param int $id The ID of the lesson progress record to update.
     * @param UpdateLessonProgressDto $dto Data transfer object containing the updated details of the lesson progress.
     * @return LessonProgress The updated lesson progress record.
     * @throws Exception When progress record is not found.
     */
    public function update(int $id, UpdateLessonProgressDto $dto): LessonProgress
    {
        $progress = $this->findOrFail($id);
        $progress->update($dto->toArray());

        return $progress->fresh();
    }

    /**
     * Delete a lesson progress record.
     *
     * @param int $id The ID of the lesson progress record to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        $progress = $this->findOrFail($id);
        return $progress->delete();
    }

    /**
     * Get all progress records for a specific lesson.
     *
     * @param int $lessonId The ID of the lesson.
     * @return Collection<int, LessonProgress> Collection of lesson progress records for the specified lesson.
     */
    public function getProgressByLessonId(int $lessonId): Collection
    {
        return LessonProgress::where('lesson_id', $lessonId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
