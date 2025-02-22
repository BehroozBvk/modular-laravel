<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use EmailRule;
use PasswordRule;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Illuminate\Validation\Rule;
use Modules\Auth\DataTransferObjects\Student\LoginStudentDto;

final class LoginStudentRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => EmailRule::default(),
            'password' => PasswordRule::default(),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.max' => 'Email must not exceed 255 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'password' => 'password',
        ];
    }

    public function toDto(): LoginStudentDto
    {
        return LoginStudentDto::fromArray($this->validated());
    }
}
