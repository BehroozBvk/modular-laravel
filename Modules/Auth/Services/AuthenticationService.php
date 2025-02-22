<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Models\User;
use Modules\User\ValueObjects\Email;
use Modules\User\DataTransferObjects\CreateUserDto;
use Modules\User\DataTransferObjects\UpdateUserProfileDto;
use Modules\User\Enums\UserTypeEnum;

class AuthenticationService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function register(
        string  $name,
        string  $email,
        string  $password,
        string  $role,
        array   $permissionIds = [],
        ?string $phoneNumber = null,
        ?string $avatar = null,
        ?int    $countryId = null,
        ?string $firstName = null,
        ?string $lastName = null
    ): User {
        $user = $this->userRepository->create(new CreateUserDto(
            name: $name,
            email: new Email($email),
            password: $password,
            role: UserTypeEnum::from($role),
            permissionIds: $permissionIds,
            phoneNumber: $phoneNumber,
            avatar: $avatar,
            countryId: $countryId,
            firstName: $firstName,
            lastName: $lastName
        ));

        if (!empty($permissionIds)) {
            $user->permissions()->attach($permissionIds);
        }

        return $user;
    }

    public function updateProfile(
        int     $userId,
        string  $name,
        string  $email,
        ?string $phoneNumber = null,
        ?string $avatar = null,
        ?int    $countryId = null,
        ?string $firstName = null,
        ?string $lastName = null
    ): bool {
        return $this->userRepository->updateProfile(
            $userId,
            new UpdateUserProfileDto(
                name: $name,
                email: new Email($email),
                phoneNumber: $phoneNumber,
                avatar: $avatar,
                countryId: $countryId,
                firstName: $firstName,
                lastName: $lastName
            )
        );
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        return $this->userRepository->updatePassword($userId, $newPassword);
    }

    public function login(string $email, string $password): ?User
    {
        $email = new Email($email);
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function getUserProfile(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
}
