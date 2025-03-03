<?php

declare(strict_types=1);

namespace Modules\Student\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Student\DataTransferObjects\ListStudentsDto;
use Modules\Student\Models\Student;

/**
 * Interface for Student repository operations
 */
interface StudentRepositoryInterface
{
    /**
     * Get all students with pagination
     */
    public function paginate(ListStudentsDto $dto): LengthAwarePaginator;

    /**
     * Find a student by ID
     */
    public function findById(int $id): ?Student;
}
