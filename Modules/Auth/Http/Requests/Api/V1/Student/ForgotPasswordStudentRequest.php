<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Student\PasswordResetStudentDto;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ForgotPasswordStudentRequest",
 *     required={"email"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="student@example.com"
 *     )
 * )
 */
final class ForgotPasswordStudentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }

    public function toDto(): PasswordResetStudentDto
    {
        return new PasswordResetStudentDto(
            email: new Email($this->input('email'))
        );
    }
}
