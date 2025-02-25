<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Student;

use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\UserPasswordResetToken;
use Illuminate\Support\Facades\{Hash};
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Auth\DataTransferObjects\Student\{
    LoginStudentDto,
    ChangePasswordStudentDto,
    PasswordResetStudentDto,
    RegisterStudentDto,
    ResetPasswordStudentDto,
    VerifyEmailStudentDto,
    ResendVerificationEmailStudentDto
};
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\Auth\Events\Student\{
    StudentPasswordResetRequested,
    StudentEmailVerificationRequested,
    StudentEmailVerified
};
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * Service for handling student authentication
 */
final class StudentAuthService
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Authenticate a student and generate access token
     *
     * @param LoginStudentDto $dto Login credentials
     * @throws AuthenticationException If credentials are invalid
     * @return PersonalAccessTokenResult Generated access token
     */
    public function login(LoginStudentDto $dto): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        return $user->createToken('student-access-token');
    }

    /**
     * Change student's password
     *
     * @param ChangePasswordStudentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function changePassword(ChangePasswordStudentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->currentPassword, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_PASSWORD)
            );
        }

        $this->userRepository->updatePassword($dto->userId, $dto->newPassword);
    }

    /**
     * Send password reset link to student's email
     *
     * @param PasswordResetStudentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function sendPasswordResetLink(PasswordResetStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::createToken((string) $dto->email);

        event(new StudentPasswordResetRequested($user, $passwordReset->plainToken));
    }

    /**
     * Reset student's password
     *
     * @param ResetPasswordStudentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resetPassword(ResetPasswordStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (!$passwordReset) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_PASSWORD_RESET_TOKEN)
            );
        }

        $this->userRepository->updatePassword($user->id, $dto->password);
        $passwordReset->delete();
    }

    /**
     * Register a new student
     *
     * @param RegisterStudentDto $dto
     * @throws AuthenticationException If registration fails
     * @return User
     */
    public function register(RegisterStudentDto $dto): User
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_ALREADY_REGISTERED)
            );
        }

        $user = $this->userRepository->create($dto);
        event(new StudentEmailVerificationRequested($user));

        return $user;
    }

    /**
     * Verify student's email
     *
     * @param VerifyEmailStudentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function verifyEmail(VerifyEmailStudentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (!hash_equals($dto->hash, sha1($user->getEmailForVerification()))) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_EMAIL_VERIFICATION_LINK)
            );
        }

        $user->markEmailAsVerified();
        event(new StudentEmailVerified($user));
    }

    /**
     * Resend verification email to student
     *
     * @param ResendVerificationEmailStudentDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function resendVerificationEmail(ResendVerificationEmailStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || $user->type !== UserTypeEnum::STUDENT->value) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        event(new StudentEmailVerificationRequested($user));
    }
}
