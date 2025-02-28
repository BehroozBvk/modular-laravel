<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\StudentParent\ResetPasswordStudentParentDto;
use Modules\User\ValueObjects\Email;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Schema(
 *     schema="ResetPasswordStudentParentRequest",
 *     required={"email", "token", "password", "password_confirmation"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="student@example.com"
 *     ),
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         example="1234567890"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="newpassword123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         example="newpassword123"
 *     )
 * )
 */
final class ResetPasswordStudentParentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'exists:users,email'
            ],
            'token' => [
                'required',
                'string'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'token.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_TOKEN_REQUIRED),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
            'password.confirmed' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_CONFIRMED),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'token' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_TOKEN),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
        ];
    }

    public function toDto(): ResetPasswordStudentParentDto
    {
        return new ResetPasswordStudentParentDto(
            email: new Email($this->input('email')),
            token: $this->input('token'),
            password: $this->input('password')
        );
    }
}
