<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Admin;

use Modules\Admin\Models\AdminPasswordResetToken;
use Illuminate\Support\Facades\{Hash};
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Auth\DataTransferObjects\Admin\{
    LoginAdminDto,
    ChangePasswordAdminDto,
    PasswordResetAdminDto,
    RegisterAdminDto,
    ResetPasswordAdminDto,
    VerifyEmailAdminDto,
    ResendVerificationEmailAdminDto
};
use Modules\Admin\Interfaces\Repositories\AdminRepositoryInterface;
use Modules\Admin\Models\Admin;
use Modules\Auth\Events\Admin\{
    AdminPasswordResetRequested,
    AdminEmailVerificationRequested,
    AdminEmailVerified
};
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * Service for handling admin authentication
 */
final class AdminAuthService
{
    /**
     * @param AdminRepositoryInterface $adminRepository
     */
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository
    ) {}

    /**
     * Authenticate an admin and generate access token
     *
     * @param LoginAdminDto $dto Login credentials
     * @throws AuthenticationException If credentials are invalid
     * @return PersonalAccessTokenResult Generated access token
     */
    public function login(LoginAdminDto $dto): PersonalAccessTokenResult
    {
        $admin = $this->adminRepository->findByEmail($dto->email);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->password, $admin->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_CREDENTIALS)
            );
        }

        return $admin->createToken('admin-access-token');
    }

    /**
     * Change admin's password
     *
     * @param ChangePasswordAdminDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function changePassword(ChangePasswordAdminDto $dto): void
    {
        $admin = $this->adminRepository->findById($dto->adminId);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->currentPassword, $admin->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_PASSWORD)
            );
        }

        $this->adminRepository->updatePassword($dto->adminId, $dto->newPassword);
    }

    /**
     * Send password reset link to admin's email
     *
     * @param PasswordResetAdminDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function sendPasswordResetLink(PasswordResetAdminDto $dto): void
    {
        $admin = $this->adminRepository->findByEmail($dto->email);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_NOT_FOUND)
            );
        }

        $passwordReset = AdminPasswordResetToken::createToken((string) $dto->email);

        event(new AdminPasswordResetRequested($admin, $passwordReset->plainToken));
    }

    /**
     * Reset admin's password
     *
     * @param ResetPasswordAdminDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resetPassword(ResetPasswordAdminDto $dto): void
    {
        $admin = $this->adminRepository->findByEmail($dto->email);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_NOT_FOUND)
            );
        }

        $passwordReset = AdminPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (!$passwordReset) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_PASSWORD_RESET_TOKEN)
            );
        }

        $this->adminRepository->updatePassword($admin->id, $dto->password);
        $passwordReset->delete();
    }

    /**
     * Register a new admin
     *
     * @param RegisterAdminDto $dto
     * @throws AuthenticationException If registration fails
     * @return Admin
     */
    public function register(RegisterAdminDto $dto): Admin
    {
        $existingAdmin = $this->adminRepository->findByEmail($dto->email);

        if ($existingAdmin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_ALREADY_REGISTERED)
            );
        }

        $admin = $this->adminRepository->create($dto);
        event(new AdminEmailVerificationRequested($admin));

        return $admin;
    }

    /**
     * Verify admin's email
     *
     * @param VerifyEmailAdminDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function verifyEmail(VerifyEmailAdminDto $dto): void
    {
        $admin = $this->adminRepository->findById($dto->adminId);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_NOT_FOUND)
            );
        }

        if ($admin->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (!hash_equals($dto->hash, sha1($admin->getEmailForVerification()))) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_INVALID_EMAIL_VERIFICATION_LINK)
            );
        }

        $admin->markEmailAsVerified();
        event(new AdminEmailVerified($admin));
    }

    /**
     * Resend verification email to admin
     *
     * @param ResendVerificationEmailAdminDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resendVerificationEmail(ResendVerificationEmailAdminDto $dto): void
    {
        $admin = $this->adminRepository->findByEmail($dto->email);

        if (!$admin) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_NOT_FOUND)
            );
        }

        if ($admin->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::ADMIN_EMAIL_ALREADY_VERIFIED)
            );
        }

        event(new AdminEmailVerificationRequested($admin));
    }
}
