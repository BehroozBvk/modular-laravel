<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\StudentParent\PasswordResetStudentParentDto;
use Modules\User\ValueObjects\Email;

final class PasswordResetStudentParentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }

    public function toDto(): PasswordResetStudentParentDto
    {
        return new PasswordResetStudentParentDto(
            email: new Email($this->input('email'))
        );
    }
}
