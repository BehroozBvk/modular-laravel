<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\ListLessonProgressDto;

final class ListLessonProgressRequest extends BaseApiV1FormRequest
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
            'sort_by' => ['sometimes', 'string', 'in:created_at,memorization_level,recitation_quality,mistakes_count'],
            'sort_direction' => ['sometimes', 'string', 'in:asc,desc'],
            'lesson_id' => ['sometimes', 'integer', 'exists:lessons,id'],
            'student_id' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }

    public function toDto(): ListLessonProgressDto
    {
        return ListLessonProgressDto::fromArray($this->validated());
    }
}
