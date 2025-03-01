<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Teacher;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Auth\DataTransferObjects\Teacher\{
    LoginTeacherDto,
    PasswordResetTeacherDto,
    RegisterTeacherDto,
    ResendVerificationEmailTeacherDto,
    ResetPasswordTeacherDto,
    VerifyEmailTeacherDto
};
use Modules\User\Models\User;
use Modules\User\Enums\UserTypeEnum;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Events\Teacher\{
    TeacherPasswordResetRequested,
    TeacherEmailVerificationRequested,
    TeacherEmailVerified
};
use Illuminate\Support\Facades\URL;

/**
 * Service for handling teacher authentication
 */
final class TeacherAuthService
{
    /**
     * Register a new teacher
     *
     * @param RegisterTeacherDto $dto Registration data
     * @return User The created teacher
     */
    public function register(RegisterTeacherDto $dto): User
    {
        $teacher = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'type' => UserTypeEnum::TEACHER,
        ]);

        event(new TeacherEmailVerificationRequested($teacher));

        return $teacher;
    }

    /**
     * Authenticate a teacher and generate access token
     *
     * @param LoginTeacherDto $dto Login credentials
     * @throws AuthenticationException If credentials are invalid
     * @return PersonalAccessTokenResult Generated access token
     */
    public function login(LoginTeacherDto $dto): PersonalAccessTokenResult
    {
        $teacher = User::where('email', (string) $dto->email)
            ->where('type', UserTypeEnum::TEACHER->value)
            ->first();

        if (!$teacher) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_CREDENTIALS)
            );
        }

        if (!Hash::check($dto->password, $teacher->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_CREDENTIALS)
            );
        }

        return $teacher->createToken('teacher-access-token');
    }

    /**
     * Send password reset link to teacher's email
     *
     * @param PasswordResetTeacherDto $dto
     * @throws AuthenticationException
     * @return void
     */
    public function sendPasswordResetLink(PasswordResetTeacherDto $dto): void
    {
        $teacher = User::where('email', (string) $dto->email)
            ->where('type', UserTypeEnum::TEACHER->value)
            ->first();

        if (!$teacher) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        $token = app('auth.password.broker')->createToken($teacher);

        event(new TeacherPasswordResetRequested($teacher, $token));
    }

    /**
     * Reset teacher's password
     *
     * @param ResetPasswordTeacherDto $dto Reset password data
     * @throws AuthenticationException If token is invalid or teacher not found
     */
    public function resetPassword(ResetPasswordTeacherDto $dto): void
    {
        $teacher = User::where('email', (string) $dto->email)
            ->where('type', UserTypeEnum::TEACHER->value)
            ->first();

        if (!$teacher) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        $status = app('auth.password.broker')->reset(
            [
                'email' => (string) $dto->email,
                'password' => $dto->password,
                'token' => $dto->token,
            ],
            function (User $user, string $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($status !== 'passwords.reset') {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_TOKEN)
            );
        }
    }

    /**
     * Resend verification email to teacher
     *
     * @param ResendVerificationEmailTeacherDto $dto
     * @throws AuthenticationException If teacher not found or email already verified
     */
    public function resendVerificationEmail(ResendVerificationEmailTeacherDto $dto): void
    {
        $teacher = User::where('email', (string) $dto->email)
            ->where('type', UserTypeEnum::TEACHER->value)
            ->first();

        if (!$teacher) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        if ($teacher->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_EMAIL_ALREADY_VERIFIED)
            );
        }

        event(new TeacherEmailVerificationRequested($teacher));
    }

    /**
     * Verify teacher's email address
     *
     * @param VerifyEmailTeacherDto $dto Verification data
     * @throws AuthenticationException If verification fails
     */
    public function verifyEmail(VerifyEmailTeacherDto $dto): void
    {
        $teacher = User::where('id', $dto->id)
            ->where('type', UserTypeEnum::TEACHER->value)
            ->first();

        if (!$teacher) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_NOT_FOUND)
            );
        }

        if ($teacher->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (!hash_equals($dto->hash, sha1($teacher->getEmailForVerification()))) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::TEACHER_INVALID_EMAIL_VERIFICATION_LINK)
            );
        }

        $teacher->markEmailAsVerified();

        event(new TeacherEmailVerified($teacher));
    }
}
