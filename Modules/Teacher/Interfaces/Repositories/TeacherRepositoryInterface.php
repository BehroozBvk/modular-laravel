<?php

declare(strict_types=1);

namespace Modules\Teacher\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Models\Teacher;

interface TeacherRepositoryInterface
{
    /**
     * Get all teachers with pagination
     */
    public function paginate(ListTeacherDto $dto): LengthAwarePaginator;

    /**
     * Find a teacher by ID
     */
    public function findById(int $id): ?Teacher;

    /**
     * Find a teacher by email
     */
    public function findByEmail(Email $email): ?Teacher;

    /**
     * Create a new teacher with or without a user
     */
    public function create(CreateTeacherDto $dto): Teacher;

    /**
     * Update a teacher
     */
    public function update(int $id, UpdateTeacherDto $dto): bool;

    /**
     * Delete a teacher
     */
    public function delete(int $id): bool;

    /**
     * Update teacher's password
     */
    public function updatePassword(int $id, string $password): void;
}
