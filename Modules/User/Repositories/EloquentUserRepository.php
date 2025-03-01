<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use Modules\User\Models\User;
use Modules\Shared\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function findById(int $id): ?User
    {
        return $this->userModel->find($id);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->userModel->where('email', (string) $email)->first();
    }

    public function create(CreateUserDto $dto): User
    {
        return $this->userModel->create($dto->toArray());
    }

    public function updatePassword(int $userId, string $password): void
    {
        $this->userModel->where('id', $userId)->update([
            'password' => $password
        ]);
    }
}
