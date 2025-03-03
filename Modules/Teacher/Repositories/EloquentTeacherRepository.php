<?php

declare(strict_types=1);

namespace Modules\Teacher\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Teacher\Models\Teacher;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\User;

final class EloquentTeacherRepository implements TeacherRepositoryInterface
{
    public function __construct(
        private readonly Teacher $teacherModel,
        private readonly User $userModel,
    ) {}

    public function paginate(ListTeacherDto $dto): LengthAwarePaginator
    {
        return $this->teacherModel
            ->query()
            ->with(['user', 'country'])
            ->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage);
    }

    public function findById(int $id): ?Teacher
    {
        return $this->teacherModel
            ->with(['user', 'country'])
            ->find($id);
    }

    public function findByEmail(Email $email): ?Teacher
    {
        return $this->teacherModel
            ->whereHas('user', fn($query) => $query->where('email', $email->value()))
            ->with(['user', 'country'])
            ->first();
    }

    public function create(CreateTeacherDto $dto): Teacher
    {
        return DB::transaction(function () use ($dto) {
            $userId = $dto->userId;

            if (! $userId) {
                if (! $dto->email || ! $dto->password) {
                    throw new \InvalidArgumentException('Email and password are required when creating a new user');
                }

                $user = $this->userModel->create([
                    'email' => $dto->email,
                    'password' => $dto->password,
                    'type' => UserTypeEnum::TEACHER,
                ]);

                $userId = $user->id;
            }

            return $this->teacherModel->create([
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
        });
    }

    public function update(int $id, UpdateTeacherDto $dto): bool
    {
        $teacher = $this->findById($id);

        if (! $teacher) {
            return false;
        }

        return $teacher->update($dto->toArray());
    }

    public function delete(int $id): bool
    {
        $teacher = $this->findById($id);

        if (! $teacher) {
            return false;
        }

        return $teacher->delete();
    }

    public function updatePassword(int $id, string $password): void
    {
        $teacher = $this->findById($id);

        if (! $teacher || ! $teacher->user) {
            return;
        }

        $teacher->user->update([
            'password' => Hash::make($password),
        ]);
    }
}
