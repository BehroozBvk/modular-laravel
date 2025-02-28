<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Admin\PasswordResetAdminDto;

final class PasswordResetAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }

    public function toDto(): PasswordResetAdminDto
    {
        return PasswordResetAdminDto::fromArray($this->validated());
    }
}
