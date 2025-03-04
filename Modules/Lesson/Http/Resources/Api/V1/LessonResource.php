<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Lesson\Models\Lesson;

/**
 * @extends JsonResource<Lesson>
 */
final class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Lesson $this */
        return [
            'id' => $this->id,
            'teacher_id' => $this->teacher_id,
            'student_id' => $this->student_id,
            'surah' => $this->surah,
            'ayah_from' => $this->ayah_from,
            'ayah_to' => $this->ayah_to,
            'date' => $this->date?->toISOString(),
            'homework' => $this->homework,
            'feedback' => $this->feedback,
            'progress' => LessonProgressResource::collection($this->whenLoaded('progress')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
