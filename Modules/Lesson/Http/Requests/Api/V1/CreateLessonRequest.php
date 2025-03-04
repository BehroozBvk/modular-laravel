<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\CreateLessonDto;

final class CreateLessonRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => ['required', 'integer', 'exists:users,id'],
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'surah' => ['required', 'string', 'max:255'],
            'ayah_from' => ['required', 'integer', 'min:1'],
            'ayah_to' => ['required', 'integer', 'min:1', 'gte:ayah_from'],
            'date' => ['required', 'date_format:Y-m-d'],
            'homework' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
        ];
    }

    public function toDto(): CreateLessonDto
    {
        return CreateLessonDto::fromArray($this->validated());
    }
}
