<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class ListLessonsDto
{
    public function __construct(
        public int $perPage,
        public string $sortBy,
        public string $sortDirection,
        public ?int $studentId = null,
        public ?int $teacherId = null,
        public ?string $date = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            perPage: (int) ($data['per_page'] ?? 15),
            sortBy: $data['sort_by'] ?? 'date',
            sortDirection: strtolower($data['sort_direction'] ?? 'desc'),
            studentId: isset($data['student_id']) ? (int) $data['student_id'] : null,
            teacherId: isset($data['teacher_id']) ? (int) $data['teacher_id'] : null,
            date: $data['date'] ?? null,
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
            'student_id' => $this->studentId,
            'teacher_id' => $this->teacherId,
            'date' => $this->date,
        ];
    }
}
