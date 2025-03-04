<?php

declare(strict_types=1);

namespace Modules\Teacher\Interfaces\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Models\Teacher;

/**
 * Interface for Teacher Repository
 * 
 * Provides methods for managing teacher records.
 */
interface TeacherRepositoryInterface
{
    /**
     * Get paginated teachers based on filters.
     *
     * @param ListTeacherDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Teacher> Paginated list of teachers.
     */
    public function paginate(ListTeacherDto $dto): LengthAwarePaginator;

    /**
     * Find a teacher by ID.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findById(int $id): ?Teacher;

    /**
     * Find a teacher by ID or throw an exception if not found.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher The teacher.
     * @throws Exception When teacher is not found.
     */
    public function findOrFail(int $id): Teacher;

    /**
     * Find a teacher by email.
     *
     * @param Email $email The email to search for.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findByEmail(Email $email): ?Teacher;

    /**
     * Create a new teacher with or without a user.
     *
     * @param CreateTeacherDto $dto Data transfer object containing the details of the teacher to create.
     * @return Teacher The created teacher.
     * @throws Exception When teacher creation fails or required data is missing.
     */
    public function create(CreateTeacherDto $dto): Teacher;

    /**
     * Update an existing teacher.
     *
     * @param int $id The ID of the teacher to update.
     * @param UpdateTeacherDto $dto Data transfer object containing the updated details of the teacher.
     * @return Teacher The updated teacher.
     * @throws Exception When teacher is not found.
     */
    public function update(int $id, UpdateTeacherDto $dto): Teacher;

    /**
     * Delete a teacher.
     *
     * @param int $id The ID of the teacher to delete.
     * @return bool True if the deletion was successful.
     * @throws Exception When teacher is not found.
     */
    public function delete(int $id): bool;

    /**
     * Update teacher's password.
     *
     * @param int $id The ID of the teacher.
     * @param string $password The new password.
     * @throws Exception When teacher or associated user is not found.
     */
    public function updatePassword(int $id, string $password): void;
}
