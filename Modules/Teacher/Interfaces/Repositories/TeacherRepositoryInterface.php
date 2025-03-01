<?php

declare(strict_types=1);

namespace Modules\Teacher\Interfaces\Repositories;

use Modules\Teacher\Models\Teacher;
use Modules\Shared\ValueObjects\Email;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;

interface TeacherRepositoryInterface
{
    public function findById(int $id): ?Teacher;

    public function findByEmail(Email $email): ?Teacher;

    public function create(RegisterTeacherDto $dto): Teacher;

    public function updatePassword(int $id, string $password): void;
}
