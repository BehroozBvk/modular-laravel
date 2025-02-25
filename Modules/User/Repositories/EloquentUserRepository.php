<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use Modules\User\Models\User;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\ValueObjects\Email;
use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(Email $email): ?User
    {
        return User::where('email', (string) $email)->first();
    }

    public function create(RegisterStudentDto $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'type' => UserTypeEnum::STUDENT->value,
        ]);
    }

    public function updatePassword(int $userId, string $password): void
    {
        User::where('id', $userId)->update([
            'password' => $password
        ]);
    }
}
