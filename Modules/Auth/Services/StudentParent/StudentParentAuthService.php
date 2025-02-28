<?php

declare(strict_types=1);

namespace Modules\Auth\Services\StudentParent;

use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\UserPasswordResetToken;
use Illuminate\Support\Facades\{Hash};
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Auth\DataTransferObjects\StudentParent\{
    LoginStudentParentDto,
    ChangePasswordStudentParentDto,
    PasswordResetStudentParentDto,
    RegisterStudentParentDto,
    ResetPasswordStudentParentDto,
    VerifyEmailStudentParentDto,
    ResendVerificationEmailStudentParentDto
};
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\Auth\Events\StudentParent\{
    StudentParentPasswordResetRequested,
    StudentParentEmailVerificationRequested,
    StudentParentEmailVerified
};
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * Service for handling student parent authentication
 */
final class StudentParentAuthService
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Authenticate a student parent and generate access token
     *
     * @param LoginStudentParentDto $dto Login credentials
     * @throws AuthenticationException If credentials are invalid
     * @return PersonalAccessTokenResult Generated access token
     */
    public function login(LoginStudentParentDto $dto): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        return $user->createToken('student-parent-access-token');
    }

    /**
     * Change student parent's password
     *
     * @param ChangePasswordStudentParentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function changePassword(ChangePasswordStudentParentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->currentPassword, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_INVALID_PASSWORD)
            );
        }

        $this->userRepository->updatePassword($dto->userId, $dto->newPassword);
    }

    /**
     * Send password reset link to student parent's email
     *
     * @param PasswordResetStudentParentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function sendPasswordResetLink(PasswordResetStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
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
     * @param ResetPasswordStudentParentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resetPassword(ResetPasswordStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (!$passwordReset) {
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
     * @param RegisterStudentParentDto $dto
     * @throws AuthenticationException If registration fails
     * @return User
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
     * @param VerifyEmailStudentParentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function verifyEmail(VerifyEmailStudentParentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (!hash_equals($dto->hash, sha1($user->getEmailForVerification()))) {
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
     * @param ResendVerificationEmailStudentParentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resendVerificationEmail(ResendVerificationEmailStudentParentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT_PARENT->value) {
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
