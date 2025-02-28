<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\StudentParent\ResendVerificationEmailStudentParentDto;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="ResendVerificationEmailStudentParentRequest",
 *     required={"email"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="student@example.com"
 *     )
 * )
 */
final class ResendVerificationEmailStudentParentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function toDto(): ResendVerificationEmailStudentParentDto
    {
        return new ResendVerificationEmailStudentParentDto(
            new Email($this->input('email'))
        );
    }
}
