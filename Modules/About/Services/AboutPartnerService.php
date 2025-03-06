<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Models\AboutPartner;
use Modules\Shared\Services\FileStorageService;

/**
 * Service for managing about partners
 */
final class AboutPartnerService
{
    /**
     * AboutPartnerService constructor
     */
    public function __construct(
        private readonly AboutPartnerRepositoryInterface $partnerRepository,
        private readonly FileStorageService $fileStorage
    ) {}

    /**
     * Get all partners
     * 
     * @return Collection<int, AboutPartner>
     */
    public function getPartners(): Collection
    {
        return $this->partnerRepository->getAll();
    }

    /**
     * Create a new partner
     * 
     * @param array<string, mixed> $data
     * @return AboutPartner
     */
    public function createPartner(array $data): AboutPartner
    {
        if (isset($data['icon_path']) && $data['icon_path'] instanceof UploadedFile) {
            $data['icon_path'] = $this->fileStorage->store(
                file: $data['icon_path'],
                path: 'about/partners/icons'
            );
        }

        return $this->partnerRepository->create($data);
    }

    /**
     * Update an existing partner
     * 
     * @param int $id
     * @param array<string, mixed> $data
     * @return AboutPartner|null
     */
    public function updatePartner(int $id, array $data): ?AboutPartner
    {
        $partner = $this->partnerRepository->findAboutPartnerOrFail($id);

        if (isset($data['icon_path']) && $data['icon_path'] instanceof UploadedFile) {
            $this->fileStorage->delete($partner->getRawOriginal('icon_path'));

            $data['icon_path'] = $this->fileStorage->store(
                file: $data['icon_path'],
                path: 'about/partners/icons'
            );
        }

        return $this->partnerRepository->update($id, $data);
    }

    /**
     * Delete a partner
     * 
     * @param int $id
     * @return bool
     */
    public function deletePartner(int $id): bool
    {
        $partner = $this->partnerRepository->findAboutPartnerOrFail($id);

        $this->fileStorage->delete($partner->getRawOriginal('icon_path'));

        return $this->partnerRepository->delete($id);
    }

    /**
     * Reorder partners
     * 
     * @param array<int, int> $orderedIds
     * @return bool
     */
    public function reorderPartners(array $orderedIds): bool
    {
        return $this->partnerRepository->reorder($orderedIds);
    }
}
