<?php

declare(strict_types=1);

namespace Modules\Activity\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Activity\Interfaces\Repositories\ActivityRepositoryInterface;
use Modules\Activity\Models\Activity;
use Modules\Shared\Services\FileStorageService;

/**
 * Service for handling activity operations
 */
final class ActivityService
{
    /**
     * Create a new service instance.
     *
     * @param ActivityRepositoryInterface $activityRepository
     * @param FileStorageService $fileStorage
     */
    public function __construct(
        private readonly ActivityRepositoryInterface $activityRepository,
        private readonly FileStorageService $fileStorage
    ) {}

    /**
     * Get all activities
     *
     * @return Collection<int, Activity>
     */
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getAllActivities();
    }

    /**
     * Get activity by ID
     *
     * @param int $id The activity ID
     * @return Activity
     * @throws ModelNotFoundException
     */
    public function getActivityById(int $id): Activity
    {
        return $this->activityRepository->findActivityOrFail($id);
    }

    /**
     * Get activity by slug
     *
     * @param string $slug The activity slug
     * @return Activity
     * @throws ModelNotFoundException
     */
    public function getActivityBySlug(string $slug): Activity
    {
        return $this->activityRepository->findBySlugOrFail($slug);
    }
}
