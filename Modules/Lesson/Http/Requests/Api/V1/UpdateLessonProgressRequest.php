<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Requests\Api\V1;

use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;
use Modules\Lesson\DataTransferObjects\UpdateLessonProgressDto;

final class UpdateLessonProgressRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'memorization_level' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'recitation_quality' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'mistakes_count' => ['sometimes', 'integer', 'min:0'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function toDto(): UpdateLessonProgressDto
    {
        return UpdateLessonProgressDto::fromArray($this->validated());
    }
}
