<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Models\AboutTeamMember;

/**
 * Interface for About Team Members repository operations
 */
interface AboutTeamMemberRepositoryInterface
{
    /**
     * Get all team members
     */
    public function getAll(): Collection;

    /**
     * Find a team member by ID
     */
    public function findById(int $id): ?AboutTeamMember;

    /**
     * Create a new team member
     */
    public function create(array $data): AboutTeamMember;

    /**
     * Update an existing team member
     */
    public function update(int $id, array $data): ?AboutTeamMember;

    /**
     * Delete a team member
     */
    public function delete(int $id): bool;

    /**
     * Reorder team members
     */
    public function reorder(array $orderedIds): bool;

    /**
     * Find a team member by ID or fail
     */
    public function findAboutTeamMemberOrFail(int $id): AboutTeamMember;
}
