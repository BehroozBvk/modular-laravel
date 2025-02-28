<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Shared\ValueObjects\Email;
use Illuminate\Contracts\Validation\Rule;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Admin\LoginAdminDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;

/**
 * @OA\Schema(
 *     schema="LoginAdminRequest",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="admin@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="password123"
 *     )
 * )
 */
final class LoginAdminRequest extends BaseApiV1FormRequest
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

    public function toDto(): LoginAdminDto
    {
        return new LoginAdminDto(
            email: new Email($this->input('email')),
            password: $this->input('password')
        );
    }
}
