<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Teacher;

use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="RegisterTeacherRequest",
 *     required={"name", "email", "password", "password_confirmation"},
 *
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="teacher@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         example="password123"
 *     )
 * )
 */
final class RegisterTeacherRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_NAME_REQUIRED),
            'name.min' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_NAME_MIN),
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'email.unique' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_UNIQUE),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
            'password.min' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_MIN),
            'password.confirmed' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_CONFIRMED),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_NAME),
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
        ];
    }

    public function toDto(): RegisterTeacherDto
    {
        return new RegisterTeacherDto(
            name: $this->input('name'),
            email: new Email($this->input('email')),
            password: $this->input('password')
        );
    }
}
