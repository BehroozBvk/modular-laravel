<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Teacher\DataTransferObjects\ListTeacherDto;

final class ListTeachersRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'sort_by' => ['sometimes', 'string', 'in:created_at,first_name,last_name'],
            'sort_direction' => ['sometimes', 'string', 'in:asc,desc'],
        ];
    }

    public function toDto(): ListTeacherDto
    {
        return ListTeacherDto::fromArray($this->validated());
    }
}
