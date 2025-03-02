<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Teacher;

use Illuminate\Support\Facades\DB;
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
use Modules\Teacher\Models\Teacher;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
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
     * @param RegisterTeacherDto $dto Registration data
     * @return Teacher The created teacher
     * @throws AuthenticationException
     */
    public function register(RegisterTeacherDto $dto): Teacher
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_ALREADY_REGISTERED)
            );
        }

        return DB::transaction(function () use ($dto) {
            // Create user with CreateUserDto
            $user = $this->userRepository->create($dto->toCreateUserDto());

            // Create teacher with teacher-specific data
            $teacher = Teacher::create(array_merge(
                $dto->toTeacherArray(),
                ['user_id' => $user->id]
            ));

            $teacher->load(['user', 'country']);

            event(new TeacherEmailVerificationRequested($teacher));

            return $teacher;
        });
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

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $teacher->load('user');
        event(new TeacherEmailVerificationRequested($teacher));
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
