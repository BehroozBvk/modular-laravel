<?php

declare(strict_types=1);

namespace Modules\StudentParent\Repositories;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\ValueObjects\Email;
use Modules\StudentParent\DataTransferObjects\CreateStudentParentDto;
use Modules\StudentParent\DataTransferObjects\ListStudentParentDto;
use Modules\StudentParent\DataTransferObjects\UpdateStudentParentDto;
use Modules\StudentParent\Interfaces\Repositories\StudentParentRepositoryInterface;
use Modules\StudentParent\Models\StudentParent;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\User;

/**
 * Eloquent implementation of the StudentParentRepositoryInterface.
 * 
 * Provides methods for managing student parent records using Eloquent ORM.
 */
final class EloquentStudentParentRepository implements StudentParentRepositoryInterface
{
    public function __construct(
        private readonly StudentParent $studentParentModel,
        private readonly User $userModel,
    ) {}

    /**
     * Get paginated student parents based on filters.
     *
     * @param ListStudentParentDto $dto Data transfer object containing filter and pagination information.
     * @return LengthAwarePaginator<StudentParent> Paginated list of student parents.
     */
    public function paginate(ListStudentParentDto $dto): LengthAwarePaginator
    {
        return $this->studentParentModel
            ->query()
            ->with(['user', 'country', 'students'])
            ->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage);
    }

    /**
     * Find a student parent by ID.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findById(int $id): ?StudentParent
    {
        return $this->studentParentModel
            ->with(['user', 'country', 'students'])
            ->find($id);
    }

    /**
     * Find a student parent by ID or throw an exception if not found.
     *
     * @param int $id The ID of the student parent.
     * @return StudentParent The student parent.
     * @throws Exception When student parent is not found.
     */
    public function findOrFail(int $id): StudentParent
    {
        return $this->studentParentModel
            ->with(['user', 'country', 'students'])
            ->findOrFail($id);
    }

    /**
     * Find a student parent by email.
     *
     * @param Email $email The email to search for.
     * @return StudentParent|null The student parent or null if not found.
     */
    public function findByEmail(Email $email): ?StudentParent
    {
        return $this->studentParentModel
            ->whereHas('user', fn($query) => $query->where('email', $email->value()))
            ->with(['user', 'country', 'students'])
            ->first();
    }

    /**
     * Create a new student parent with or without a user.
     *
     * @param CreateStudentParentDto $dto Data transfer object containing the details of the student parent to create.
     * @return StudentParent The created student parent.
     * @throws Exception When student parent creation fails or required data is missing.
     */
    public function create(CreateStudentParentDto $dto): StudentParent
    {
        try {
            return DB::transaction(function () use ($dto): StudentParent {
                $userId = $dto->userId;

                if (! $userId) {
                    if (! $dto->email || ! $dto->password) {
                        throw new Exception('Email and password are required when creating a new user');
                    }

                    $user = $this->userModel->create([
                        'email' => $dto->email,
                        'password' => $dto->password,
                        'type' => UserTypeEnum::STUDENT_PARENT,
                    ]);

                    $userId = $user->id;
                }

                $studentParent = $this->studentParentModel->create([
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

                return $studentParent->fresh(['user', 'country', 'students']);
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
     * @throws Exception When student parent is not found.
     */
    public function update(int $id, UpdateStudentParentDto $dto): StudentParent
    {
        try {
            return DB::transaction(function () use ($id, $dto): StudentParent {
                $studentParent = $this->findOrFail($id);
                $studentParent->update($dto->toArray());

                return $studentParent->fresh(['user', 'country', 'students']);
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
     * @throws Exception When student parent is not found.
     */
    public function delete(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id): bool {
                $studentParent = $this->findOrFail($id);
                return $studentParent->delete();
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
     * @throws Exception When student parent or associated user is not found.
     */
    public function updatePassword(int $id, string $password): void
    {
        try {
            DB::transaction(function () use ($id, $password): void {
                $studentParent = $this->findOrFail($id);

                if (! $studentParent->user) {
                    throw new Exception('Student parent has no associated user account');
                }

                $studentParent->user->update([
                    'password' => Hash::make($password),
                ]);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to update student parent password: ' . $e->getMessage());
        }
    }
}
