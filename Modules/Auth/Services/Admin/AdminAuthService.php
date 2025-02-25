<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Admin;

use Illuminate\Support\Facades\{Hash, Mail};
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Admin\Models\{Admin, AdminPasswordResetToken};
use Modules\Auth\Mail\AdminPasswordResetMail;
use Modules\Admin\Interfaces\Repositories\AdminRepositoryInterface;

final class AdminAuthService
{
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository
    ) {}

    public function login(string $email, string $password): PersonalAccessTokenResult
    {
        $admin = $this->adminRepository->findByEmail($email);

        if (!$admin || !Hash::check($password, $admin->password)) {
            throw new AuthenticationException('Invalid admin credentials');
        }

        return $admin->createToken('admin-access-token');
    }

}
