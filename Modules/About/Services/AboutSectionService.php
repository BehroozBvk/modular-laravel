<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Models\AboutSection;

/**
 * Service for about section operations
 */
final class AboutSectionService
{
    public function __construct(
        private readonly AboutSectionRepositoryInterface $sectionRepository
    ) {}

    /**
     * Get all about sections
     */
    public function getSections(): Collection
    {
        return $this->sectionRepository->getAll();
    }

    /**
     * Create a new section
     */
    public function createSection(array $data): AboutSection
    {
        return $this->sectionRepository->create($data);
    }

    /**
     * Update an existing section
     */
    public function updateSection(int $id, array $data): ?AboutSection
    {
        return $this->sectionRepository->update($id, $data);
    }

    /**
     * Delete a section
     */
    public function deleteSection(int $id): bool
    {
        return $this->sectionRepository->delete($id);
    }

    /**
     * Reorder sections
     */
    public function reorderSections(array $orderedIds): bool
    {
        return $this->sectionRepository->reorder($orderedIds);
    }
}
