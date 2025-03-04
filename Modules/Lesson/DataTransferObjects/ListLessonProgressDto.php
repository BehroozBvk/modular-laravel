<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class ListLessonProgressDto
{
    public function __construct(
        public int $perPage,
        public string $sortBy,
        public string $sortDirection,
        public ?int $lessonId = null,
        public ?int $studentId = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            perPage: (int) ($data['per_page'] ?? 15),
            sortBy: $data['sort_by'] ?? 'created_at',
            sortDirection: strtolower($data['sort_direction'] ?? 'desc'),
            lessonId: isset($data['lesson_id']) ? (int) $data['lesson_id'] : null,
            studentId: isset($data['student_id']) ? (int) $data['student_id'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
            'sort_by' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
            'lesson_id' => $this->lessonId,
            'student_id' => $this->studentId,
        ];
    }
}
