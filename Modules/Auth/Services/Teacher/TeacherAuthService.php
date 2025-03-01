<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Teacher;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Teacher\LoginTeacherDto;
use Modules\Auth\DataTransferObjects\Teacher\PasswordResetTeacherDto;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Modules\Auth\DataTransferObjects\Teacher\ResendVerificationEmailTeacherDto;
use Modules\Auth\DataTransferObjects\Teacher\ResetPasswordTeacherDto;
use Modules\Auth\DataTransferObjects\Teacher\VerifyEmailTeacherDto;
use Modules\Auth\Events\Teacher\TeacherEmailVerificationRequested;
use Modules\Auth\Events\Teacher\TeacherEmailVerified;
use Modules\Auth\Events\Teacher\TeacherPasswordResetRequested;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\User\Models\UserPasswordResetToken;

/**
 * Service for handling teacher authentication
 */
final class TeacherAuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new teacher
     *
     * @param  RegisterTeacherDto  $dto  Registration data
     * @return User The created teacher
     */
    public function register(RegisterTeacherDto $dto): User
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_ALREADY_REGISTERED)
            );
        }

        $user = $this->userRepository->create($dto);
        event(new TeacherEmailVerificationRequested($user));

        return $user;
    }

    /**
     * Authenticate a teacher and generate access token
     *
     * @param  LoginTeacherDto  $dto  Login credentials
     * @return PersonalAccessTokenResult Generated access token
     *
     * @throws AuthenticationException If credentials are invalid
     */
    public function login(LoginTeacherDto $dto): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::TEACHER) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_CREDENTIALS)
            );
        }

        if (! Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_CREDENTIALS)
            );
        }

        return $user->createToken('teacher-access-token');
    }

    /**
     * Send password reset link to teacher's email
     *
     * @throws AuthenticationException
     */
    public function sendPasswordResetLink(PasswordResetTeacherDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::TEACHER) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::createToken((string) $dto->email);

        event(new TeacherPasswordResetRequested($user, $passwordReset->plainToken));
    }

    /**
     * Reset teacher's password
     *
     * @param  ResetPasswordTeacherDto  $dto  Reset password data
     *
     * @throws AuthenticationException If token is invalid or teacher not found
     */
    public function resetPassword(ResetPasswordTeacherDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::TEACHER) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (! $passwordReset) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_PASSWORD_RESET_TOKEN)
            );
        }

        $this->userRepository->updatePassword($user->id, $dto->password);
        $passwordReset->delete();
    }

    /**
     * Resend verification email to teacher
     *
     * @throws AuthenticationException If teacher not found or email already verified
     */
    public function resendVerificationEmail(ResendVerificationEmailTeacherDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::TEACHER) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_EMAIL_ALREADY_VERIFIED)
            );
        }

        event(new TeacherEmailVerificationRequested($user));
    }

    /**
     * Verify teacher's email address
     *
     * @param  VerifyEmailTeacherDto  $dto  Verification data
     *
     * @throws AuthenticationException If verification fails
     */
    public function verifyEmail(VerifyEmailTeacherDto $dto): void
    {
        $user = $this->userRepository->findById($dto->id);

        if (! $user || $user->type !== UserTypeEnum::TEACHER) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (! hash_equals($dto->hash, sha1($user->getEmailForVerification()))) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_EMAIL_VERIFICATION_LINK)
            );
        }

        $user->markEmailAsVerified();
        event(new TeacherEmailVerified($user));
    }
}
