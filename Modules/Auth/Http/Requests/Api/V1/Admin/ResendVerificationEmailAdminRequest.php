<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Admin\ResendVerificationEmailAdminDto;
use Modules\Shared\ValueObjects\Email;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Schema(
 *     schema="ResendVerificationEmailAdminRequest",
 *     required={"email"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="admin@example.com"
 *     )
 * )
 */
final class ResendVerificationEmailAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'exists:admins,email'
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

    public function toDto(): ResendVerificationEmailAdminDto
    {
        return new ResendVerificationEmailAdminDto(
            email: new Email($this->input('email'))
        );
    }
}
