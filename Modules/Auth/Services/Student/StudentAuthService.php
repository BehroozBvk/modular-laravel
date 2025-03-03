<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Student;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Student\ChangePasswordStudentDto;
use Modules\Auth\DataTransferObjects\Student\LoginStudentDto;
use Modules\Auth\DataTransferObjects\Student\PasswordResetStudentDto;
use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\Auth\DataTransferObjects\Student\ResendVerificationEmailStudentDto;
use Modules\Auth\DataTransferObjects\Student\ResetPasswordStudentDto;
use Modules\Auth\DataTransferObjects\Student\VerifyEmailStudentDto;
use Modules\Auth\Events\Student\StudentEmailVerificationRequested;
use Modules\Auth\Events\Student\StudentEmailVerified;
use Modules\Auth\Events\Student\StudentPasswordResetRequested;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\User\Models\UserPasswordResetToken;
use Modules\Student\Models\Student;

/**
 * Service for handling student authentication
 */
final class StudentAuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new student
     *
     * @throws AuthenticationException If registration fails
     */
    public function register(RegisterStudentDto $dto): Student
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_ALREADY_REGISTERED)
            );
        }

        return DB::transaction(function () use ($dto) {
            $user = $this->userRepository->create($dto->toCreateUserDto());

            $studentData = array_merge(
                $dto->toStudentArray(),
                ['user_id' => $user->id]
            );

            $student = Student::create($studentData);

            event(new StudentEmailVerificationRequested($user));

            return $student;
        });
    }

    /**
     * Authenticate a student and generate access token
     *
     * @throws AuthenticationException If credentials are invalid
     */
    public function login(LoginStudentDto $dto): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        if (! Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        return $user->createToken('student-access-token');
    }

    /**
     * Change student's password
     *
     * @throws AuthenticationException
     */
    public function changePassword(ChangePasswordStudentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_CREDENTIALS)
            );
        }

        if (! Hash::check($dto->currentPassword, $user->password)) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_PASSWORD)
            );
        }

        $this->userRepository->updatePassword($user->id, $dto->newPassword);
    }

    /**
     * Send password reset link to student's email
     *
     * @throws AuthenticationException
     */
    public function sendPasswordResetLink(PasswordResetStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
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
     * @throws AuthenticationException
     */
    public function resetPassword(ResetPasswordStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        $passwordReset = UserPasswordResetToken::findValidToken((string) $dto->email, $dto->token);

        if (! $passwordReset) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_INVALID_PASSWORD_RESET_TOKEN)
            );
        }

        $this->userRepository->updatePassword($user->id, $dto->password);
        $passwordReset->delete();
    }

    /**
     * Verify student's email
     *
     * @throws AuthenticationException
     */
    public function verifyEmail(VerifyEmailStudentDto $dto): void
    {
        $user = $this->userRepository->findById($dto->userId);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_NOT_FOUND)
            );
        }

        if ($user->hasVerifiedEmail()) {
            throw new AuthenticationException(
                AuthMessageConstants::get(AuthMessageConstants::STUDENT_EMAIL_ALREADY_VERIFIED)
            );
        }

        if (! hash_equals($dto->hash, sha1($user->getEmailForVerification()))) {
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
     * @throws AuthenticationException
     */
    public function resendVerificationEmail(ResendVerificationEmailStudentDto $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || $user->type !== UserTypeEnum::STUDENT) {
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
