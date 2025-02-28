<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Admin\ChangePasswordAdminDto;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Schema(
 *     schema="ChangePasswordAdminRequest",
 *     required={"current_password", "password", "password_confirmation"},
 *     @OA\Property(
 *         property="current_password",
 *         type="string",
 *         format="password",
 *         example="currentPassword123"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="newPassword123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         example="newPassword123"
 *     )
 * )
 */
final class ChangePasswordAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'different:current_password'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_CURRENT_PASSWORD_REQUIRED),
            'current_password.current_password' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_CURRENT_PASSWORD_MATCH),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
            'password.confirmed' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_CONFIRMED),
            'password.different' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_NEW_PASSWORD_DIFFERENT),
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_CURRENT_PASSWORD),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_NEW_PASSWORD),
        ];
    }

    public function toDto(): ChangePasswordAdminDto
    {
        return new ChangePasswordAdminDto(
            adminId: $this->user()->id,
            currentPassword: $this->input('current_password'),
            newPassword: $this->input('password')
        );
    }
}
