<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\User\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(RegisterStudentDto $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'type' => UserTypeEnum::STUDENT->value,
        ]);
    }

    public function updatePassword(int $userId, string $hashedPassword): void
    {
        User::where('id', $userId)->update([
            'password' => $hashedPassword
        ]);
    }
}
