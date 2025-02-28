<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Illuminate\Validation\Rule;
use Modules\User\ValueObjects\Email;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\StudentParent\LoginStudentParentDto;

/**
 * @OA\Schema(
 *     schema="LoginStudentRequest",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="student@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="password123"
 *     )
 * )
 */
final class LoginStudentParentRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email'
            ],
            'password' => [
                'required',
                'string'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
        ];
    }

    public function toDto(): LoginStudentParentDto
    {
        return new LoginStudentParentDto(
            email: new Email($this->input('email')),
            password: $this->input('password')
        );
    }
}
