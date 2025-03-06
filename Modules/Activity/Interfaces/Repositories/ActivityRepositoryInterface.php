<?php

declare(strict_types=1);

namespace Modules\Activity\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Activity\Models\Activity;

/**
 * Interface for activity repositories
 */
interface ActivityRepositoryInterface
{
    /**
     * Get all activities
     * 
     * @return Collection<int, Activity>
     */
    public function getAllActivities(): Collection;

    /**
     * Find an activity by ID
     * 
     * @param int $id The activity ID
     * @return Activity|null
     */
    public function findById(int $id): ?Activity;

    /**
     * Find an activity by ID or fail
     * 
     * @param int $id The activity ID
     * @return Activity
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findActivityOrFail(int $id): Activity;

    /**
     * Find an activity by slug
     * 
     * @param string $slug The activity slug
     * @return Activity|null
     */
    public function findBySlug(string $slug): ?Activity;

    /**
     * Find an activity by slug or fail
     * 
     * @param string $slug The activity slug
     * @return Activity
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlugOrFail(string $slug): Activity;
}
