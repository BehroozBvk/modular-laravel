<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Admin\PasswordResetAdminDto;
use Modules\User\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ForgotPasswordAdminRequest",
 *     required={"email"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="admin@example.com"
 *     )
 * )
 */
final class ForgotPasswordAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }

    public function toDto(): PasswordResetAdminDto
    {
        return new PasswordResetAdminDto(
            email: new Email($this->input('email'))
        );
    }
}
