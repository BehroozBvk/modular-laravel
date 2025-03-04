<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\ListLessonsDto;

final class ListLessonsRequest extends BaseApiV1FormRequest
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
            'sort_by' => ['sometimes', 'string', 'in:date,created_at,student_id,teacher_id'],
            'sort_direction' => ['sometimes', 'string', 'in:asc,desc'],
            'student_id' => ['sometimes', 'integer', 'exists:users,id'],
            'teacher_id' => ['sometimes', 'integer', 'exists:users,id'],
            'date' => ['sometimes', 'date_format:Y-m-d'],
        ];
    }

    public function toDto(): ListLessonsDto
    {
        return ListLessonsDto::fromArray($this->validated());
    }
}
