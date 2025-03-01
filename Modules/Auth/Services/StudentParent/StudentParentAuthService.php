<?php

declare(strict_types=1);

namespace Modules\Auth\Services\StudentParent;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\StudentParent\ChangePasswordStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\LoginStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\PasswordResetStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\RegisterStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\ResendVerificationEmailStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\ResetPasswordStudentParentDto;
use Modules\Auth\DataTransferObjects\StudentParent\VerifyEmailStudentParentDto;
use Modules\Auth\Events\StudentParent\StudentParentEmailVerificationRequested;
use Modules\Auth\Events\StudentParent\StudentParentEmailVerified;
use Modules\Auth\Events\StudentParent\StudentParentPasswordResetRequested;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\User\Models\UserPasswordResetToken;

/**
 * Service for handling student parent authentication
 */
final class StudentParentAuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Authenticate a student parent and generate access token
     *
     * @param  LoginStudentParentDto  $dto  Login credentials
     * @return PersonalAccessTokenResult Generated access token
     *
     * @throws AuthenticationException If credentials are invalid
     */
    public function login(LoginStudentParentDto $dto): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        if (! Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        return $user->createToken('student-parent-access-token');
    }

    /**
     * Change student parent's password
     *
     * @throws AuthenticationException
     */
    public function changePassword(ChangePasswordStudentParentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        if (! Hash::check($dto->currentPassword, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_PASSWORD)
            );
        }

        $this->userRepository->updatePassword($dto->userId, $dto->newPassword);
    }

    /**
     * Send password reset link to student parent's email
     *
     * @throws AuthenticationException
     */
    public function sendPasswordResetLink(PasswordResetStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::createToken((string) $dto->email);

        event(new StudentParentPasswordResetRequested($user, $passwordReset->plainToken));
    }

    /**
     * Reset student parent's password
     *
     * @throws AuthenticationException
     */
    public function resetPassword(ResetPasswordStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (! $passwordReset) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_PASSWORD_RESET_TOKEN)
            );
        }

        $this->userRepository->updatePassword($user->id, $dto->password);
        $passwordReset->delete();
    }

    /**
     * Register a new student parent
     *
     * @throws AuthenticationException If registration fails
     */
    public function register(RegisterStudentParentDto $dto): User
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_ALREADY_REGISTERED)
            );
        }

        $user = $this->userRepository->create($dto);
        event(new StudentParentEmailVerificationRequested($user));

        return $user;
    }

    /**
     * Verify student parent's email
     *
     * @throws AuthenticationException
     */
    public function verifyEmail(VerifyEmailStudentParentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (! hash_equals($dto->hash, sha1($user->getEmailForVerification()))) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_EMAIL_VERIFICATION_LINK)
            );
        }

        $user->markEmailAsVerified();
        event(new StudentParentEmailVerified($user));
    }

    /**
     * Resend verification email to student parent
     *
     * @throws AuthenticationException
     */
    public function resendVerificationEmail(ResendVerificationEmailStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        event(new StudentParentEmailVerificationRequested($user));
    }
}
