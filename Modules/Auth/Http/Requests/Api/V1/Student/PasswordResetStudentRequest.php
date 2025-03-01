<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Auth\DataTransferObjects\Student\PasswordResetStudentDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;

final class PasswordResetStudentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function toDto(): PasswordResetStudentDto
    {
        return PasswordResetStudentDto::fromArray($this->validated());
    }
}
