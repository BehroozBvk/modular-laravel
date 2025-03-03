<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Student\RegisterStudentDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Core\Rules\EmailRule;
use Modules\Core\Rules\PasswordRule;
use Modules\Core\Rules\RelationRule;
use Modules\Core\Rules\StringRule;
use Modules\Shared\Rules\ImageRule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RegisterStudentRequest",
 *     required={"name", "email", "password", "password_confirmation"},
 *
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
            'email' => EmailRule::default(unique: true),
            'password' => PasswordRule::default(confirmed: true),
            'password_confirmation' => PasswordRule::confirmation(),
            'student_parent_id' => ['required', 'integer', 'exists:student_parents,id'],
            'phone_number' => StringRule::phone(),
            'avatar' => ImageRule::avatar(),
            'country_id' => RelationRule::belongsTo('countries', required: false),
            'first_name' => StringRule::default(required: false),
            'last_name' => StringRule::default(required: false),
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:20'],
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_NAME),
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
            'role' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ROLE),
            'phone_number' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PHONE_NUMBER),
            'avatar' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_AVATAR),
            'country_id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_COUNTRY_ID),
            'first_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_FIRST_NAME),
            'last_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_LAST_NAME),
            'student_parent_id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_STUDENT_PARENT_ID),
            'address' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ADDRESS),
            'city' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_CITY),
            'state' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_STATE),
            'zip' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ZIP),
        ];
    }

    public function toDto(): RegisterStudentDto
    {
        return RegisterStudentDto::fromArray($this->validated());
    }
}
