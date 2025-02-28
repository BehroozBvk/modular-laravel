<?php

declare(strict_types=1);

namespace Modules\Admin\Interfaces\Repositories;

use Modules\Admin\Models\Admin;
use Modules\Shared\ValueObjects\Email;
use Modules\Auth\DataTransferObjects\Admin\RegisterAdminDto;

interface AdminRepositoryInterface
{
    public function findById(int $id): ?Admin;

    public function findByEmail(Email $email): ?Admin;

    public function create(RegisterAdminDto $dto): Admin;

    public function updatePassword(int $id, string $password): void;
}
