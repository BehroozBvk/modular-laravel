<?php

declare(strict_types=1);

namespace Modules\User\Interfaces\Repositories;

use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\User\Models\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(RegisterStudentDto $dto): User;
    public function updatePassword(int $userId, string $hashedPassword): void;
}
