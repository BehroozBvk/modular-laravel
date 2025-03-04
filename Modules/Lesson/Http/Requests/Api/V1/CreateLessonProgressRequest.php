<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\CreateLessonProgressDto;

final class CreateLessonProgressRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'memorization_level' => ['required', 'integer', 'min:1', 'max:10'],
            'recitation_quality' => ['required', 'integer', 'min:1', 'max:10'],
            'mistakes_count' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function toDto(): CreateLessonProgressDto
    {
        return CreateLessonProgressDto::fromArray($this->validated());
    }
}
