<?php

declare(strict_types=1);

namespace Modules\Lesson\DataTransferObjects;

final readonly class UpdateLessonProgressDto
{
    public function __construct(
        public ?int $memorizationLevel = null,
        public ?int $recitationQuality = null,
        public ?int $mistakesCount = null,
        public ?string $notes = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            memorizationLevel: isset($data['memorization_level']) ? (int) $data['memorization_level'] : null,
            recitationQuality: isset($data['recitation_quality']) ? (int) $data['recitation_quality'] : null,
            mistakesCount: isset($data['mistakes_count']) ? (int) $data['mistakes_count'] : null,
            notes: $data['notes'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->memorizationLevel !== null) {
            $result['memorization_level'] = $this->memorizationLevel;
        }

        if ($this->recitationQuality !== null) {
            $result['recitation_quality'] = $this->recitationQuality;
        }

        if ($this->mistakesCount !== null) {
            $result['mistakes_count'] = $this->mistakesCount;
        }

        if ($this->notes !== null) {
            $result['notes'] = $this->notes;
        }

        return $result;
    }
}
