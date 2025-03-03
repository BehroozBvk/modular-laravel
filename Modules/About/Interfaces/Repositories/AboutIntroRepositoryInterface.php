<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Modules\About\Models\AboutIntro;

/**
 * Interface for AboutIntro repository operations
 */
interface AboutIntroRepositoryInterface
{
    /**
     * Get the active about intro
     */
    public function getActive(): ?AboutIntro;

    /**
     * Find an about intro by ID
     */
    public function findById(int $id): ?AboutIntro;

    /**
     * Create a new about intro
     */
    public function create(array $data): AboutIntro;

    /**
     * Update an existing about intro
     */
    public function update(int $id, array $data): ?AboutIntro;

    /**
     * Delete an about intro
     */
    public function delete(int $id): bool;
}
