<?php

declare(strict_types=1);

namespace Modules\Student\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Student\DataTransferObjects\ListStudentsDto;
use Modules\Student\Interfaces\Repositories\StudentRepositoryInterface;
use Modules\Student\Models\Student;

/**
 * Service for student operations
 */
final class StudentService
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository
    ) {}

    /**
     * Get paginated list of students with filters
     */
    public function getStudents(ListStudentsDto $dto): LengthAwarePaginator
    {
        return $this->studentRepository->paginate($dto);
    }

    /**
     * Find a student by ID
     */
    public function findStudent(int $id): ?Student
    {
        return $this->studentRepository->findById($id);
    }
}
