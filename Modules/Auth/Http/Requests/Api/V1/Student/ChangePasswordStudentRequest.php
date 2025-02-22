<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Student\ChangePasswordStudentDto;

final class ChangePasswordStudentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string']
        ];
    }

    public function toDto(): ChangePasswordStudentDto
    {
        return ChangePasswordStudentDto::fromArray([
            'user_id' => $this->user()->id,
            'current_password' => $this->current_password,
            'password' => $this->password
        ]);
    }
}
