<?php

declare(strict_types=1);

namespace Modules\Admin\Services;

use Modules\Admin\Interfaces\Repositories\AdminRepositoryInterface;

final class AdminService
{
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository
    ) {}
}
