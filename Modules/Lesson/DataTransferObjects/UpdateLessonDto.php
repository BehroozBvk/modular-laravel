<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class UpdateLessonDto
{
    public function __construct(
        public ?int $teacherId = null,
        public ?int $studentId = null,
        public ?string $surah = null,
        public ?int $ayahFrom = null,
        public ?int $ayahTo = null,
        public ?string $date = null,
        public ?string $homework = null,
        public ?string $feedback = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            teacherId: isset($data['teacher_id']) ? (int) $data['teacher_id'] : null,
            studentId: isset($data['student_id']) ? (int) $data['student_id'] : null,
            surah: $data['surah'] ?? null,
            ayahFrom: isset($data['ayah_from']) ? (int) $data['ayah_from'] : null,
            ayahTo: isset($data['ayah_to']) ? (int) $data['ayah_to'] : null,
            date: $data['date'] ?? null,
            homework: $data['homework'] ?? null,
            feedback: $data['feedback'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->teacherId !== null) {
            $result['teacher_id'] = $this->teacherId;
        }

        if ($this->studentId !== null) {
            $result['student_id'] = $this->studentId;
        }

        if ($this->surah !== null) {
            $result['surah'] = $this->surah;
        }

        if ($this->ayahFrom !== null) {
            $result['ayah_from'] = $this->ayahFrom;
        }

        if ($this->ayahTo !== null) {
            $result['ayah_to'] = $this->ayahTo;
        }

        if ($this->date !== null) {
            $result['date'] = $this->date;
        }

        if ($this->homework !== null) {
            $result['homework'] = $this->homework;
        }

        if ($this->feedback !== null) {
            $result['feedback'] = $this->feedback;
        }

        return $result;
    }
}
