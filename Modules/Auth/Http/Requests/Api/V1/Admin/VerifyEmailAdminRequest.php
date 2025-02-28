<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Admin;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Admin\VerifyEmailAdminDto;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Schema(
 *     schema="VerifyEmailAdminRequest",
 *     required={"id", "hash", "signature", "expires"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="hash",
 *         type="string",
 *         example="1234567890"
 *     ),
 *     @OA\Property(
 *         property="signature",
 *         type="string",
 *         example="abcdef1234567890"
 *     ),
 *     @OA\Property(
 *         property="expires",
 *         type="integer",
 *         example=1234567890
 *     )
 * )
 */
final class VerifyEmailAdminRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'integer',
                'exists:admins,id'
            ],
            'hash' => [
                'required',
                'string'
            ],
            'signature' => [
                'required',
                'string'
            ],
            'expires' => [
                'required',
                'integer'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_ID_REQUIRED),
            'id.exists' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_ID_EXISTS),
            'hash.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_HASH_REQUIRED),
            'signature.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_SIGNATURE_REQUIRED),
            'expires.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_EXPIRES_REQUIRED),
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ID),
            'hash' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_HASH),
            'signature' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_SIGNATURE),
            'expires' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_EXPIRES),
        ];
    }

    public function toDto(): VerifyEmailAdminDto
    {
        return new VerifyEmailAdminDto(
            adminId: (int) $this->input('id'),
            hash: $this->input('hash'),
            signature: $this->input('signature'),
            expires: (int) $this->input('expires')
        );
    }
}
