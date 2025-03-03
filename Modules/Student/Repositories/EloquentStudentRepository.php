<?php

declare(strict_types=1);

namespace Modules\Student\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Student\DataTransferObjects\ListStudentsDto;
use Modules\Student\Interfaces\Repositories\StudentRepositoryInterface;
use Modules\Student\Models\Student;

/**
 * Eloquent implementation of the Student repository
 */
final class EloquentStudentRepository implements StudentRepositoryInterface
{
    /**
     * Get all students with pagination
     */
    public function paginate(ListStudentsDto $dto): LengthAwarePaginator
    {
        $query = Student::query()
            ->with(['user', 'studentParent'])
            ->when($dto->search, fn($query) => $query->whereHas('user', function ($q) use ($dto) {
                $q->where('first_name', 'like', "%{$dto->search}%")
                    ->orWhere('last_name', 'like', "%{$dto->search}%")
                    ->orWhere('email', 'like', "%{$dto->search}%");
            }))
            ->when($dto->student_parent_id, fn($query) => $query->where('student_parent_id', $dto->student_parent_id))
            ->when($dto->active !== null, fn($query) => $query->where('active', $dto->active));

        // Handle sorting
        if ($dto->sort) {
            $direction = $dto->direction === 'desc' ? 'desc' : 'asc';
            if (in_array($dto->sort, ['created_at', 'updated_at', 'id'])) {
                $query->orderBy($dto->sort, $direction);
            } elseif (in_array($dto->sort, ['first_name', 'last_name', 'email'])) {
                $query->orderBy("user.{$dto->sort}", $direction);
            }
        } else {
            // Default sorting by newest first
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }

    /**
     * Find a student by ID
     */
    public function findById(int $id): ?Student
    {
        return Student::with(['user', 'studentParent'])->find($id);
    }
}
