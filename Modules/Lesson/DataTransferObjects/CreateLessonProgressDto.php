<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class CreateLessonProgressDto
{
    public function __construct(
        public int $lessonId,
        public int $studentId,
        public int $memorizationLevel,
        public int $recitationQuality,
        public int $mistakesCount,
        public ?string $notes = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            lessonId: (int) $data['lesson_id'],
            studentId: (int) $data['student_id'],
            memorizationLevel: (int) $data['memorization_level'],
            recitationQuality: (int) $data['recitation_quality'],
            mistakesCount: (int) $data['mistakes_count'],
            notes: $data['notes'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'lesson_id' => $this->lessonId,
            'student_id' => $this->studentId,
            'memorization_level' => $this->memorizationLevel,
            'recitation_quality' => $this->recitationQuality,
            'mistakes_count' => $this->mistakesCount,
            'notes' => $this->notes,
        ];
    }
}
