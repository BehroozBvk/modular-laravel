<?php

declare(strict_types=1);

namespace Modules\Lesson\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;
use Modules\Lesson\Models\Lesson;

interface LessonRepositoryInterface
{
    /**
     * Get paginated lessons based on filters.
     */
    public function paginate(ListLessonsDto $dto): LengthAwarePaginator;

    /**
     * Find a lesson by its ID.
     */
    public function findById(int $id): ?Lesson;

    /**
     * Create a new lesson.
     */
    public function create(CreateLessonDto $dto): Lesson;

    /**
     * Update an existing lesson.
     */
    public function update(int $id, UpdateLessonDto $dto): bool;

    /**
     * Delete a lesson.
     */
    public function delete(int $id): bool;
}
