<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Models\AboutSection;
use Modules\Shared\Services\FileStorageService;

/**
 * Service for managing about sections
 */
final class AboutSectionService
{
    /**
     * AboutSectionService constructor
     */
    public function __construct(
        private readonly AboutSectionRepositoryInterface $sectionRepository,
        private readonly FileStorageService $fileStorage
    ) {}

    /**
     * Get all sections
     * 
     * @return Collection<int, AboutSection>
     */
    public function getSections(): Collection
    {
        return $this->sectionRepository->getAll();
    }

    /**
     * Create a new section
     * 
     * @param array<string, mixed> $data
     * @return AboutSection
     */
    public function createSection(array $data): AboutSection
    {
        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $data['image_path'] = $this->fileStorage->store(
                file: $data['image_path'],
                path: 'about/sections'
            );
        }

        return $this->sectionRepository->create($data);
    }

    /**
     * Update an existing section
     * 
     * @param int $id
     * @param array<string, mixed> $data
     * @return AboutSection|null
     */
    public function updateSection(int $id, array $data): ?AboutSection
    {
        $section = $this->sectionRepository->findAboutSectionOrFail($id);

        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $this->fileStorage->delete($section->getRawOriginal('image_path'));

            $data['image_path'] = $this->fileStorage->store(
                file: $data['image_path'],
                path: 'about/sections'
            );
        }

        return $this->sectionRepository->update($id, $data);
    }

    /**
     * Delete a section
     * 
     * @param int $id
     * @return bool
     */
    public function deleteSection(int $id): bool
    {
        $section = $this->sectionRepository->findAboutSectionOrFail($id);

        $this->fileStorage->delete(path: $section->getRawOriginal('image_path'));

        return $this->sectionRepository->delete($id);
    }

    /**
     * Reorder sections
     * 
     * @param array<int, int> $orderedIds
     * @return bool
     */
    public function reorderSections(array $orderedIds): bool
    {
        return $this->sectionRepository->reorder(orderedIds: $orderedIds);
    }
}
