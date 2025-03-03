<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Models\AboutSection;

/**
 * Interface for AboutSection repository operations
 */
interface AboutSectionRepositoryInterface
{
    /**
     * Get all about sections ordered by order
     */
    public function getAll(): Collection;

    /**
     * Find an about section by ID
     */
    public function findById(int $id): ?AboutSection;

    /**
     * Create a new about section
     */
    public function create(array $data): AboutSection;

    /**
     * Update an existing about section
     */
    public function update(int $id, array $data): ?AboutSection;

    /**
     * Delete an about section
     */
    public function delete(int $id): bool;

    /**
     * Reorder about sections
     */
    public function reorder(array $orderedIds): bool;
}
