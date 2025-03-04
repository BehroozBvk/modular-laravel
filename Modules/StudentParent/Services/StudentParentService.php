<?php

declare(strict_types=1);

namespace Modules\StudentParent\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Shared\ValueObjects\Email;
use Modules\StudentParent\DataTransferObjects\CreateStudentParentDto;
use Modules\StudentParent\DataTransferObjects\ListStudentParentDto;
use Modules\StudentParent\DataTransferObjects\UpdateStudentParentDto;
use Modules\StudentParent\Interfaces\Repositories\StudentParentRepositoryInterface;
use Modules\StudentParent\Models\StudentParent;

/**
 * Service class for managing student parents.
 * 
 * Provides methods for creating, updating, deleting, and retrieving student parents.
 */
final class StudentParentService
{
    /**
     * Constructor for StudentParentService.
     *
     * @param StudentParentRepositoryInterface $studentParentRepository The repository interface for student parent operations.
     */
    public function __construct(
        private readonly StudentParentRepositoryInterface $studentParentRepository,
    ) {}

    /**
     * Get a paginated list of student parents based on filters.
     *
     * @param ListStudentParentDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<StudentParent> Paginated list of student parents.
     */
    public function getStudentParents(ListStudentParentDto $dto): LengthAwarePaginator
    {
        return $this->studentParentRepository->paginate($dto);
    }

    /**
     * Find a specific student parent by ID.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findStudentParent(int $id): ?StudentParent
    {
        return $this->studentParentRepository->findById($id);
    }

    /**
     * Find a specific student parent by ID or throw an exception if not found.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent The student parent.
     * @throws Exception When student parent is not found.
     */
    public function findStudentParentOrFail(int $id): StudentParent
    {
        return $this->studentParentRepository->findOrFail($id);
    }

    /**
     * Find a student parent by email.
     *
     * @param Email $email The email to search for.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findStudentParentByEmail(Email $email): ?StudentParent
    {
        return $this->studentParentRepository->findByEmail($email);
    }

    /**
     * Create a new student parent.
     *
     * @param CreateStudentParentDto $dto Data transfer object containing the details of the student parent to create.
     * @return StudentParent The created student parent.
     * @throws Exception When student parent creation fails.
     */
    public function createStudentParent(CreateStudentParentDto $dto): StudentParent
    {
        try {
            return DB::transaction(function () use ($dto): StudentParent {
                return $this->studentParentRepository->create($dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to create student parent: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing student parent.
     *
     * @param int $id The ID of the student parent to update.
     * @param UpdateStudentParentDto $dto Data transfer object containing the updated details of the student parent.
     * @return StudentParent The updated student parent.
     * @throws Exception When student parent update fails.
     */
    public function updateStudentParent(int $id, UpdateStudentParentDto $dto): StudentParent
    {
        try {
            return DB::transaction(function () use ($id, $dto): StudentParent {
                return $this->studentParentRepository->update($id, $dto);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update student parent: ' . $e->getMessage());
        }
    }

    /**
     * Delete a student parent.
     *
     * @param int $id The ID of the student parent to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When student parent is not found or deletion fails.
     */
    public function deleteStudentParent(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id): bool {
                return $this->studentParentRepository->delete($id);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to delete student parent: ' . $e->getMessage());
        }
    }

    /**
     * Update student parent's password.
     *
     * @param int $id The ID of the student parent.
     * @param string $password The new password.
     * @throws Exception When student parent or associated user is not found or password update fails.
     */
    public function updateStudentParentPassword(int $id, string $password): void
    {
        try {
            DB::transaction(function () use ($id, $password): void {
                $this->studentParentRepository->updatePassword($id, $password);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update student parent password: ' . $e->getMessage());
        }
    }
}
