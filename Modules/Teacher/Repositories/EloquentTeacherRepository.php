<?php

declare(strict_types=1);

namespace Modules\Teacher\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Teacher\Models\Teacher;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\User;

/**
 * Eloquent implementation of the TeacherRepositoryInterface.
 * 
 * Provides methods for managing teacher records using Eloquent ORM.
 */
final class EloquentTeacherRepository implements TeacherRepositoryInterface
{
    public function __construct(
        private readonly Teacher $teacherModel,
        private readonly User $userModel,
    ) {}

    /**
     * Get paginated teachers based on filters.
     *
     * @param ListTeacherDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<Teacher> Paginated list of teachers.
     */
    public function paginate(ListTeacherDto $dto): LengthAwarePaginator
    {
        return $this->teacherModel
            ->query()
            ->with(['user', 'country'])
            ->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage);
    }

    /**
     * Find a teacher by ID.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findById(int $id): ?Teacher
    {
        return $this->teacherModel
            ->with(['user', 'country'])
            ->find($id);
    }

    /**
     * Find a teacher by ID or throw an exception if not found.
     *
     * @param int $id The ID of the teacher.
     * @return Teacher The teacher.
     * @throws Exception When teacher is not found.
     */
    public function findOrFail(int $id): Teacher
    {
        return $this->teacherModel
            ->with(['user', 'country'])
            ->findOrFail($id);
    }

    /**
     * Find a teacher by email.
     *
     * @param Email $email The email to search for.
     * @return Teacher|null The teacher or null if not found.
     */
    public function findByEmail(Email $email): ?Teacher
    {
        return $this->teacherModel
            ->whereHas('user', fn($query) => $query->where('email', $email->value()))
            ->with(['user', 'country'])
            ->first();
    }

    /**
     * Create a new teacher with or without a user.
     *
     * @param CreateTeacherDto $dto Data transfer object containing the details of the teacher to create.
     * @return Teacher The created teacher.
     * @throws Exception When teacher creation fails or required data is missing.
     */
    public function create(CreateTeacherDto $dto): Teacher
    {
        try {
            return DB::transaction(function () use ($dto): Teacher {
                $userId = $dto->userId;

                if (! $userId) {
                    if (! $dto->email || ! $dto->password) {
                        throw new Exception('Email and password are required when creating a new user');
                    }

                    $user = $this->userModel->create([
                        'email' => $dto->email,
                        'password' => $dto->password,
                        'type' => UserTypeEnum::TEACHER,
                    ]);

                    $userId = $user->id;
                }

                $teacher = $this->teacherModel->create([
                    'first_name' => $dto->firstName,
                    'last_name' => $dto->lastName,
                    'phone_number' => $dto->phone,
                    'address' => $dto->address,
                    'city' => $dto->city,
                    'state' => $dto->state,
                    'zip' => $dto->zip,
                    'country_id' => $dto->countryId,
                    'user_id' => $userId,
                ]);

                return $teacher->fresh(['user', 'country']);
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
     * @throws Exception When teacher is not found.
     */
    public function update(int $id, UpdateTeacherDto $dto): Teacher
    {
        try {
            return DB::transaction(function () use ($id, $dto): Teacher {
                $teacher = $this->findOrFail($id);
                $teacher->update($dto->toArray());

                return $teacher->fresh(['user', 'country']);
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
     * @throws Exception When teacher is not found.
     */
    public function delete(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id): bool {
                $teacher = $this->findOrFail($id);
                return $teacher->delete();
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
     * @throws Exception When teacher or associated user is not found.
     */
    public function updatePassword(int $id, string $password): void
    {
        try {
            DB::transaction(function () use ($id, $password): void {
                $teacher = $this->findOrFail($id);

                if (! $teacher->user) {
                    throw new Exception('Teacher has no associated user account');
                }

                $teacher->user->update([
                    'password' => $password,
                ]);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update teacher password: ' . $e->getMessage());
        }
    }
}
