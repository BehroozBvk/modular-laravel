<?php

declare(strict_types=1);

namespace Modules\Admin\Repositories;

use Modules\Admin\Interfaces\Repositories\AdminRepositoryInterface;
use Modules\Admin\Models\Admin;
use Modules\Auth\DataTransferObjects\Admin\RegisterAdminDto;
use Modules\Shared\ValueObjects\Email;

final class EloquentAdminRepository implements AdminRepositoryInterface
{
    public function __construct(
        private readonly Admin $adminModel
    ) {}

    public function findById(int $id): ?Admin
    {
        return $this->adminModel->find($id);
    }

    public function findByEmail(Email $email): ?Admin
    {
        return $this->adminModel->where('email', $email->value())->first();
    }

    public function create(RegisterAdminDto $dto): Admin
    {
        return $this->adminModel->create([
            'name' => $dto->name,
            'email' => (string) $dto->email,
            'password' => $dto->password,
        ]);
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->adminModel->where('id', $id)->update([
            'password' => $password
        ]);
    }
}
