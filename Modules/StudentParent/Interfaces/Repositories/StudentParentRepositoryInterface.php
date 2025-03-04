<?php

declare(strict_types=1);

namespace Modules\StudentParent\Interfaces\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Shared\ValueObjects\Email;
use Modules\StudentParent\DataTransferObjects\CreateStudentParentDto;
use Modules\StudentParent\DataTransferObjects\ListStudentParentDto;
use Modules\StudentParent\DataTransferObjects\UpdateStudentParentDto;
use Modules\StudentParent\Models\StudentParent;

/**
 * Interface for StudentParent Repository
 * 
 * Provides methods for managing student parent records.
 */
interface StudentParentRepositoryInterface
{
    /**
     * Get paginated student parents based on filters.
     *
     * @param ListStudentParentDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<StudentParent> Paginated list of student parents.
     */
    public function paginate(ListStudentParentDto $dto): LengthAwarePaginator;

    /**
     * Find a student parent by ID.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findById(int $id): ?StudentParent;

    /**
     * Find a student parent by ID or throw an exception if not found.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent The student parent.
     * @throws Exception When student parent is not found.
     */
    public function findOrFail(int $id): StudentParent;

    /**
     * Find a student parent by email.
     *
     * @param Email $email The email to search for.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findByEmail(Email $email): ?StudentParent;

    /**
     * Create a new student parent with or without a user.
     *
     * @param CreateStudentParentDto $dto Data transfer object containing the details of the student parent to create.
     * @return StudentParent The created student parent.
     * @throws Exception When student parent creation fails or required data is missing.
     */
    public function create(CreateStudentParentDto $dto): StudentParent;

    /**
     * Update an existing student parent.
     *
     * @param int $id The ID of the student parent to update.
     * @param UpdateStudentParentDto $dto Data transfer object containing the updated details of the student parent.
     * @return StudentParent The updated student parent.
     * @throws Exception When student parent is not found.
     */
    public function update(int $id, UpdateStudentParentDto $dto): StudentParent;

    /**
     * Delete a student parent.
     *
     * @param int $id The ID of the student parent to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When student parent is not found.
     */
    public function delete(int $id): bool;

    /**
     * Update student parent's password.
     *
     * @param int $id The ID of the student parent.
     * @param string $password The new password.
     * @throws Exception When student parent or associated user is not found.
     */
    public function updatePassword(int $id, string $password): void;
}
