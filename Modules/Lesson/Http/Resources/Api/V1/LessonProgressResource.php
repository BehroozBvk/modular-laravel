<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Lesson\Models\LessonProgress;

/**
 * @extends JsonResource<LessonProgress>
 */
final class LessonProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var LessonProgress $this */
        return [
            'id' => $this->id,
            'lesson_id' => $this->lesson_id,
            'student_id' => $this->student_id,
            'memorization_level' => $this->memorization_level,
            'recitation_quality' => $this->recitation_quality,
            'mistakes_count' => $this->mistakes_count,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
