<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Student;

use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\UserPasswordResetToken;
use Illuminate\Support\Facades\{Hash, Mail};
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\Core\Exceptions\AuthenticationException;
use Modules\Auth\DataTransferObjects\Student\{
    LoginStudentDto,
    ChangePasswordStudentDto,
    PasswordResetStudentDto,
    RegisterStudentDto
};
use Modules\Auth\Mail\StudentPasswordResetMail;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;

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
            throw new AuthenticationException('Invalid student credentials');
        }

        if (!Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException('Invalid student credentials');
        }

        return $user->createToken('student-token');
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
            throw new AuthenticationException('Invalid student credentials');
        }

        if (!Hash::check($dto->currentPassword, $user->password)) {
            throw new AuthenticationException('Current password is incorrect');
        }

        $this->userRepository->updatePassword($dto->userId, Hash::make($dto->newPassword));
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
            throw new AuthenticationException('Student not found');
        }

        $passwordReset = UserPasswordResetToken::createToken($dto->email->__toString());

        Mail::to($user->email)
            ->send(new StudentPasswordResetMail($user, $passwordReset->plainToken));
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
            throw new AuthenticationException('Email already registered');
        }

        return $this->userRepository->create($dto);
    }
}
