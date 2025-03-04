<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class CreateLessonDto
{
    public function __construct(
        public int $teacherId,
        public int $studentId,
        public string $surah,
        public int $ayahFrom,
        public int $ayahTo,
        public string $date,
        public ?string $homework = null,
        public ?string $feedback = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            teacherId: (int) $data['teacher_id'],
            studentId: (int) $data['student_id'],
            surah: $data['surah'],
            ayahFrom: (int) $data['ayah_from'],
            ayahTo: (int) $data['ayah_to'],
            date: $data['date'],
            homework: $data['homework'] ?? null,
            feedback: $data['feedback'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'teacher_id' => $this->teacherId,
            'student_id' => $this->studentId,
            'surah' => $this->surah,
            'ayah_from' => $this->ayahFrom,
            'ayah_to' => $this->ayahTo,
            'date' => $this->date,
            'homework' => $this->homework,
            'feedback' => $this->feedback,
        ];
    }
}
