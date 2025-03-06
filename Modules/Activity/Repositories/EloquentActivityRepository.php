<?php

declare(strict_types=1);

namespace Modules\Activity\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Activity\Interfaces\Repositories\ActivityRepositoryInterface;
use Modules\Activity\Models\Activity;

/**
 * Eloquent implementation of the Activity repository
 */
final class EloquentActivityRepository implements ActivityRepositoryInterface
{
    /**
     * Get all activities
     * 
     * @return Collection<int, Activity>
     */
    public function getAllActivities(): Collection
    {
        return Activity::with('translations')->get();
    }

    /**
     * Find an activity by ID
     * 
     * @param int $id The activity ID
     * @return Activity|null
     */
    public function findById(int $id): ?Activity
    {
        return Activity::with('translations')->find($id);
    }

    /**
     * Find an activity by ID or fail
     * 
     * @param int $id The activity ID
     * @return Activity
     * @throws ModelNotFoundException
     */
    public function findActivityOrFail(int $id): Activity
    {
        return Activity::with('translations')->findOrFail($id);
    }

    /**
     * Find an activity by slug
     * 
     * @param string $slug The activity slug
     * @return Activity|null
     */
    public function findBySlug(string $slug): ?Activity
    {
        return Activity::with('translations')->where('slug', $slug)->first();
    }

    /**
     * Find an activity by slug or fail
     * 
     * @param string $slug The activity slug
     * @return Activity
     * @throws ModelNotFoundException
     */
    public function findBySlugOrFail(string $slug): Activity
    {
        return Activity::with('translations')->where('slug', $slug)->firstOrFail();
    }
}
