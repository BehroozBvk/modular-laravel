<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\StudentParent\ChangePasswordStudentParentDto;


final class ChangePasswordStudentParentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'min:8'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => [
                'required',
                'string'
            ]
        ];
    }

    public function toDto(): ChangePasswordStudentParentDto
    {
        return new ChangePasswordStudentParentDto(
            userId: $this->user()->id,
            currentPassword: $this->current_password,
            newPassword: $this->password
        );
    }
}
