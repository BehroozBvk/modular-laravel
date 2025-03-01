<?php

declare(strict_types=1);

namespace Modules\Teacher\Repositories;

use Modules\Teacher\Models\Teacher;
use Modules\Teacher\Interfaces\Repositories\TeacherRepositoryInterface;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\ValueObjects\Email;

final class EloquentTeacherRepository implements TeacherRepositoryInterface
{
    public function __construct(
        private readonly Teacher $teacherModel
    ) {}

    public function findById(int $id): ?Teacher
    {
        return $this->teacherModel->find($id);
    }

    public function findByEmail(Email $email): ?Teacher
    {
        return $this->teacherModel->where('email', $email->value())->first();
    }

    public function create(RegisterTeacherDto $dto): Teacher
    {
        return $this->teacherModel->create([
            'name' => $dto->name,
            'email' => (string) $dto->email,
            'password' => Hash::make($dto->password),
            'phone_number' => $dto->phoneNumber,
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'avatar' => $dto->avatar,
            'country_id' => $dto->countryId,
        ]);
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->teacherModel->where('id', $id)->update([
            'password' => Hash::make($password)
        ]);
    }
}
