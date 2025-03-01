<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Teacher;

use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Teacher\PasswordResetTeacherDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ForgotPasswordTeacherRequest",
 *     required={"email"},
 *
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="teacher@example.com"
 *     )
 * )
 */
final class ForgotPasswordTeacherRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'exists:teachers,email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'email.exists' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EXISTS),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
        ];
    }

    public function toDto(): PasswordResetTeacherDto
    {
        return new PasswordResetTeacherDto(
            email: new Email($this->input('email'))
        );
    }
}
