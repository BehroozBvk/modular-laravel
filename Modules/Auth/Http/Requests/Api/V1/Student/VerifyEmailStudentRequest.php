<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Api\V1\Student;

use Modules\Auth\DataTransferObjects\Student\VerifyEmailStudentDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;

/**
 * @OA\Schema(
 *     schema="VerifyEmailStudentRequest",
 *     required={"id", "hash"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="hash",
 *         type="string",
 *         example="1234567890"
 *     )
 * )
 */
final class VerifyEmailStudentRequest extends BaseApiV1FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:users,id'],
            'hash' => ['required', 'string'],
        ];
    }

    public function toDto(): VerifyEmailStudentDto
    {
        return new VerifyEmailStudentDto(
            userId: (int) $this->route('id'),
            hash: $this->route('hash')
        );
    }
}
