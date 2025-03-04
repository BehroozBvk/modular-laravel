<?php

declare(strict_types=1);

namespace Modules\Lesson\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;
use Modules\Lesson\Models\LessonProgress;

interface LessonProgressRepositoryInterface
{
    /**
     * Get paginated lesson progress records based on filters.
     */
    public function paginate(ListLessonProgressDto $dto): LengthAwarePaginator;

    /**
     * Find a lesson progress record by its ID.
     */
    public function findById(int $id): ?LessonProgress;

    /**
     * Create a new lesson progress record.
     */
    public function create(CreateLessonProgressDto $dto): LessonProgress;

    /**
     * Update an existing lesson progress record.
     */
    public function update(int $id, UpdateLessonProgressDto $dto): bool;

    /**
     * Delete a lesson progress record.
     */
    public function delete(int $id): bool;

    /**
     * Get all progress records for a specific lesson.
     */
    public function getByLessonId(int $lessonId): array;
}
