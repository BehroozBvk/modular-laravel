<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Student\ResendVerificationEmailStudentDto;
use Modules\User\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ResendVerificationEmailStudentRequest",
 *     required={"email"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="student@example.com"
 *     )
 * )
 */
final class ResendVerificationEmailStudentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ];
    }

    public function toDto(): ResendVerificationEmailStudentDto
    {
        return new ResendVerificationEmailStudentDto(
            email: new Email($this->input('email'))
        );
    }
}
