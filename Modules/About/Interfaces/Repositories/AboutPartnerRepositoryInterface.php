<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Models\AboutPartner;

/**
 * Interface for AboutPartner repository operations
 */
interface AboutPartnerRepositoryInterface
{
    /**
     * Get all partners ordered by order
     */
    public function getAll(): Collection;

    /**
     * Find a partner by ID
     */
    public function findById(int $id): ?AboutPartner;

    /**
     * Create a new partner
     */
    public function create(array $data): AboutPartner;

    /**
     * Update an existing partner
     */
    public function update(int $id, array $data): ?AboutPartner;

    /**
     * Delete a partner
     */
    public function delete(int $id): bool;

    /**
     * Reorder partners
     */
    public function reorder(array $orderedIds): bool;
}
