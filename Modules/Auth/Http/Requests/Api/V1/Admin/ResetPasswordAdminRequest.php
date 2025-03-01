<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Auth\DataTransferObjects\Admin\ResetPasswordAdminDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ResetPasswordAdminRequest",
 *     required={"email", "token", "password", "password_confirmation"},
 *
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="admin@example.com"
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
final class ResetPasswordAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function toDto(): ResetPasswordAdminDto
    {
        return new ResetPasswordAdminDto(
            email: new Email($this->input('email')),
            token: $this->input('token'),
            password: $this->input('password')
        );
    }
}
