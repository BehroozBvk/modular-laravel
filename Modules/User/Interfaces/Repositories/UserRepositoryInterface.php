<?php

declare(strict_types=1);

namespace Modules\User\Interfaces\Repositories;

use Modules\User\Models\User;
use Modules\Shared\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function create(CreateUserDto $dto): User;
    public function updatePassword(int $userId, string $password): void;
}
