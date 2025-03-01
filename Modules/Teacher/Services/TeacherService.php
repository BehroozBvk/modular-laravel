<?php

declare(strict_types=1);

namespace Modules\Teacher\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Modules\Shared\ValueObjects\Email;
use Modules\Teacher\DataTransferObjects\CreateTeacherDto;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;
use Modules\Teacher\DataTransferObjects\UpdateTeacherDto;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Teacher\Models\Teacher;

final class TeacherService
{
    public function __construct(
        private readonly TeacherRepositoryInterface $teacherRepository,
    ) {}

    public function getTeachers(ListTeacherDto $dto): LengthAwarePaginator
    {
        return $this->teacherRepository->paginate($dto);
    }

    public function findTeacher(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    public function findTeacherByEmail(Email $email): ?Teacher
    {
        return $this->teacherRepository->findByEmail($email);
    }

    public function createTeacher(CreateTeacherDto $dto): Teacher
    {
        return $this->teacherRepository->create($dto);
    }

    public function updateTeacher(int $id, UpdateTeacherDto $dto): bool
    {
        return $this->teacherRepository->update($id, $dto);
    }

    public function deleteTeacher(int $id): bool
    {
        return $this->teacherRepository->delete($id);
    }

    public function updateTeacherPassword(int $id, string $password): void
    {
        $this->teacherRepository->updatePassword($id, $password);
    }
}
