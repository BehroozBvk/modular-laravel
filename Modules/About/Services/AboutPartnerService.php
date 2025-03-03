<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Models\AboutPartner;

/**
 * Service for about partner operations
 */
final class AboutPartnerService
{
    public function __construct(
        private readonly AboutPartnerRepositoryInterface $partnerRepository
    ) {}

    /**
     * Get all partners
     */
    public function getPartners(): Collection
    {
        return $this->partnerRepository->getAll();
    }

    /**
     * Create a new partner
     */
    public function createPartner(array $data): AboutPartner
    {
        return $this->partnerRepository->create($data);
    }

    /**
     * Update an existing partner
     */
    public function updatePartner(int $id, array $data): ?AboutPartner
    {
        return $this->partnerRepository->update($id, $data);
    }

    /**
     * Delete a partner
     */
    public function deletePartner(int $id): bool
    {
        return $this->partnerRepository->delete($id);
    }

    /**
     * Reorder partners
     */
    public function reorderPartners(array $orderedIds): bool
    {
        return $this->partnerRepository->reorder($orderedIds);
    }
}
