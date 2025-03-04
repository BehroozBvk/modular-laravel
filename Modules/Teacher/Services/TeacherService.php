<?php

declare(strict_types=1);

namespace Modules\Teacher\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Teacher\Models\Teacher;

/**
 * Service class for managing teachers.
 * 
 * Provides methods for creating, updating, deleting, and retrieving teachers.
 */
final class TeacherService
{
    /**
     * Constructor for TeacherService.
     *
     * @param TeacherRepositoryInterface $teacherRepository The repository interface for teacher operations.
     */
    public function __construct(
        private readonly TeacherRepositoryInterface $teacherRepository,
    ) {}

    /**
     * Get a paginated list of teachers based on filters.
     *
     * @param ListTeacherDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Teacher> Paginated list of teachers.
     */
    public function getTeachers(ListTeacherDto $dto): LengthAwarePaginator
    {
        return $this->teacherRepository->paginate($dto);
    }

    /**
     * Find a specific teacher by ID.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findTeacher(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    /**
     * Find a specific teacher by ID or throw an exception if not found.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher The teacher.
     * @throws Exception When teacher is not found.
     */
    public function findTeacherOrFail(int $id): Teacher
    {
        return $this->teacherRepository->findOrFail($id);
    }

    /**
     * Find a teacher by email.
     *
     * @param Email $email The email to search for.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findTeacherByEmail(Email $email): ?Teacher
    {
        return $this->teacherRepository->findByEmail($email);
    }

    /**
     * Create a new teacher.
     *
     * @param CreateTeacherDto $dto Data transfer object containing the details of the teacher to create.
     * @return Teacher The created teacher.
     * @throws Exception When teacher creation fails.
     */
    public function createTeacher(CreateTeacherDto $dto): Teacher
    {
        try {
            return DB::transaction(function () use ($dto): Teacher {
                return $this->teacherRepository->create($dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to create teacher: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing teacher.
     *
     * @param int $id The ID of the teacher to update.
     * @param UpdateTeacherDto $dto Data transfer object containing the updated details of the teacher.
     * @return Teacher The updated teacher.
     * @throws Exception When teacher update fails.
     */
    public function updateTeacher(int $id, UpdateTeacherDto $dto): Teacher
    {
        try {
            return DB::transaction(function () use ($id, $dto): Teacher {
                return $this->teacherRepository->update($id, $dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update teacher: ' . $e->getMessage());
        }
    }

    /**
     * Delete a teacher.
     *
     * @param int $id The ID of the teacher to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When teacher is not found or deletion fails.
     */
    public function deleteTeacher(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id): bool {
                return $this->teacherRepository->delete($id);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to delete teacher: ' . $e->getMessage());
        }
    }

    /**
     * Update teacher's password.
     *
     * @param int $id The ID of the teacher.
     * @param string $password The new password.
     * @throws Exception When teacher or associated user is not found or password update fails.
     */
    public function updateTeacherPassword(int $id, string $password): void
    {
        try {
            DB::transaction(function () use ($id, $password): void {
                $this->teacherRepository->updatePassword($id, $password);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update teacher password: ' . $e->getMessage());
        }
    }
}
