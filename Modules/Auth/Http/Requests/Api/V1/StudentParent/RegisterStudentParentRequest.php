<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\StudentParent;

use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\StudentParent\RegisterStudentParentDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Shared\ValueObjects\Email;

final class RegisterStudentParentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:15',
            ],
            'first_name' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'min:3',
                'max:255',
            ],
            'last_name' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'min:3',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            ],
            'country_id' => [
                'nullable',
                'integer',
                'exists:countries,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_NAME_REQUIRED),
            'name.regex' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_NAME_REGEX),
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'email.unique' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_UNIQUE),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
            'password.confirmed' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_CONFIRMED),
            'phone_number.regex' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PHONE_NUMBER_REGEX),
            'phone_number.min' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PHONE_NUMBER_MIN),
            'phone_number.max' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PHONE_NUMBER_MAX),
            'avatar.image' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_AVATAR_IMAGE),
            'avatar.mimes' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_AVATAR_MIMES),
            'avatar.dimensions' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_AVATAR_DIMENSIONS),
            'avatar.max' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_AVATAR_MAX),
            'country_id.exists' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_COUNTRY_ID_EXISTS),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_NAME),
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
            'phone_number' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PHONE_NUMBER),
            'avatar' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_AVATAR),
            'country_id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_COUNTRY_ID),
            'first_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_FIRST_NAME),
            'last_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_LAST_NAME),
        ];
    }

    public function toDto(): RegisterStudentParentDto
    {
        return new RegisterStudentParentDto(
            name: $this->input('name'),
            email: new Email($this->input('email')),
            password: $this->input('password'),
            phoneNumber: $this->input('phone_number'),
            firstName: $this->input('first_name'),
            lastName: $this->input('last_name'),
            avatar: $this->file('avatar')?->store('avatars', 'public'),
            countryId: $this->input('country_id'),
        );
    }
}
