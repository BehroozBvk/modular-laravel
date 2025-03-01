<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Teacher;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Auth\DataTransferObjects\Teacher\VerifyEmailTeacherDto;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Schema(
 *     schema="VerifyEmailTeacherRequest",
 *     required={"id", "hash"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="hash",
 *         type="string",
 *         example="verification-hash"
 *     )
 * )
 */
final class VerifyEmailTeacherRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
            'hash' => [
                'required',
                'string'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_ID_REQUIRED),
            'id.exists' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_ID_EXISTS),
            'hash.required' => AuthMessageConstants::get(AuthMessageConstants::VALIDATION_HASH_REQUIRED),
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_ID),
            'hash' => AuthMessageConstants::get(AuthMessageConstants::ATTRIBUTE_HASH),
        ];
    }

    public function toDto(): VerifyEmailTeacherDto
    {
        $id = $this->route('id');
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException('Invalid ID parameter');
        }

        return new VerifyEmailTeacherDto(
            id: (int) $id,
            hash: (string) $this->route('hash')
        );
    }
}
