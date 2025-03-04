<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\UpdateLessonDto;

final class UpdateLessonRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => ['sometimes', 'integer', 'exists:users,id'],
            'student_id' => ['sometimes', 'integer', 'exists:users,id'],
            'surah' => ['sometimes', 'string', 'max:255'],
            'ayah_from' => ['sometimes', 'integer', 'min:1'],
            'ayah_to' => ['sometimes', 'integer', 'min:1', 'gte:ayah_from'],
            'date' => ['sometimes', 'date_format:Y-m-d'],
            'homework' => ['sometimes', 'nullable', 'string'],
            'feedback' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function toDto(): UpdateLessonDto
    {
        return UpdateLessonDto::fromArray($this->validated());
    }
}
