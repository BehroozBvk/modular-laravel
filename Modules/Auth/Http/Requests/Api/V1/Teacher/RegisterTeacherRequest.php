<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Teacher;

use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\DataTransferObjects\Teacher\RegisterTeacherDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Shared\ValueObjects\Email;

/**
 * @OA\Schema(
 *     schema="RegisterTeacherRequest",
 *     required={"email", "password", "password_confirmation", "first_name", "last_name", "phone", "address", "city", "state", "zip", "country_id"},
 *
 *     @OA\Property(property="email", type="string", format="email", example="teacher@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="address", type="string", example="123 Main St"),
 *     @OA\Property(property="city", type="string", example="New York"),
 *     @OA\Property(property="state", type="string", example="NY"),
 *     @OA\Property(property="zip", type="string", example="10001"),
 *     @OA\Property(property="country_id", type="integer", example=1)
 * )
 */
final class RegisterTeacherRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
            'state' => [
                'required',
                'string',
                'max:255',
            ],
            'zip' => [
                'required',
                'string',
                'max:255',
            ],
            'country_id' => [
                'required',
                'integer',
                'exists:countries,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_REQUIRED),
            'email.email' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_EMAIL),
            'email.unique' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EMAIL_UNIQUE),
            'password.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_REQUIRED),
            'password.min' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_MIN),
            'password.confirmed' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_PASSWORD_CONFIRMED),
            'first_name.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'last_name.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'phone.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'address.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'city.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'state.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'zip.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'country_id.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
            'country_id.exists' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_REQUIRED),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EMAIL),
            'password' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PASSWORD),
            'first_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_FIRST_NAME),
            'last_name' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_LAST_NAME),
            'phone' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_PHONE_NUMBER),
            'address' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ADDRESS),
            'city' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_CITY),
            'state' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_STATE),
            'zip' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ZIP),
            'country_id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_COUNTRY),
        ];
    }

    public function toDto(): RegisterTeacherDto
    {
        return RegisterTeacherDto::fromArray($this->validated());
    }
}
