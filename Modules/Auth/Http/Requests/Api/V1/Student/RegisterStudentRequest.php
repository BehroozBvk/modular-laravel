<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use OpenApi\Annotations as OA;
use Modules\Shared\Rules\ImageRule;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\Core\Rules\{StringRule, EmailRule, PasswordRule, RelationRule};

/**
 * @OA\Schema(
 *     schema="RegisterStudentRequest",
 *     required={"name", "email", "password", "password_confirmation"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="StrongPass123!"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="StrongPass123!"),
 *     @OA\Property(property="phone_number", type="string", nullable=true, example="+1234567890"),
 *     @OA\Property(property="avatar", type="string", format="binary", nullable=true),
 *     @OA\Property(property="country_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="first_name", type="string", nullable=true, example="John"),
 *     @OA\Property(property="last_name", type="string", nullable=true, example="Doe")
 * )
 */
final class RegisterStudentRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => StringRule::name(),
            'email' => EmailRule::default(unique: true),
            'password' => PasswordRule::default(confirmed: true),
            'password_confirmation' => PasswordRule::confirmation(),
            'phone_number' => StringRule::phone(),
            'avatar' => ImageRule::avatar(),
            'country_id' => RelationRule::belongsTo('countries', required: false),
            'first_name' => StringRule::default(required: false),
            'last_name' => StringRule::default(required: false),
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
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters, spaces, and hyphens.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'phone_number.regex' => 'Invalid phone number format.',
            'phone_number.min' => 'Phone number must be at least 10 characters.',
            'phone_number.max' => 'Phone number must not exceed 20 characters.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpg, png, jpeg, gif, or svg.',
            'avatar.dimensions' => 'Image dimensions must be between 100x100 and 1000x1000 pixels.',
            'avatar.max' => 'The image must not be larger than 2MB.',
            'country_id.exists' => 'Selected country does not exist.',
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
            'name' => 'full name',
            'email' => 'email address',
            'password' => 'password',
            'role' => 'user role',
            'phone_number' => 'phone number',
            'avatar' => 'profile avatar',
            'country_id' => 'country',
            'first_name' => 'first name',
            'last_name' => 'last name',
        ];
    }

    public function toDto(): RegisterStudentDto
    {
        return RegisterStudentDto::fromArray($this->validated());
    }
}
