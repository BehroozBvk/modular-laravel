<?php

declare(strict_types=1);

namespace Modules\Activity\Http\Controllers\Api\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Activity\Http\Resources\Api\V1\ActivityResource;
use Modules\Activity\Services\ActivityService;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;

/**
 * @group Activity Management
 *
 * APIs for managing activities
 */
final class GetActivityByIdController extends BaseApiV1Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ActivityService $activityService
    ) {}

    /**
     * Get activity by ID
     *
     * This endpoint retrieves a specific activity by its ID.
     *
     * @urlParam id integer required The ID of the activity. Example: 1
     * 
     * @response status=200 scenario="Success" {
     *     "status": "success",
     *     "message": "Activity retrieved successfully",
     *     "data": {
     *         "id": 1,
     *         "slug": "summer-coding-camp",
     *         "main_image": "https://example.com/images/main.jpg",
     *         "cover_image": "https://example.com/images/cover.jpg",
     *         "video": "https://example.com/videos/intro.mp4",
     *         "activity_time": "2025-06-15 10:00:00",
     *         "alt_image": "https://example.com/images/alt.jpg",
     *         "points": 10,
     *         "title": "Summer Coding Camp",
     *         "short_description": "Learn coding in a fun environment",
     *         "category": "Programming",
     *         "description": "A comprehensive coding camp for beginners",
     *         "activity_type": "Camp",
     *         "meta_title": "Summer Coding Camp | Learn to Code",
     *         "meta_description": "Join our summer coding camp and learn to code in a fun environment",
     *         "meta_tags": "coding, camp, summer, programming",
     *         "created_at": "2025-03-01 12:00:00",
     *         "updated_at": "2025-03-01 12:00:00"
     *     }
     * }
     *
     * @response status=404 scenario="Activity Not Found" {
     *     "status": "error",
     *     "message": "Activity not found",
     *     "data": null
     * }
     * 
     * @response status=500 scenario="Server Error" {
     *     "status": "error",
     *     "message": "An error occurred while retrieving the activity",
     *     "data": null
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $activity = $this->activityService->getActivityById($id);

            return $this->successResponse(
                data: new ActivityResource($activity),
                message: 'Activity retrieved successfully'
            );
        } catch (Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $this->errorResponse(
                    message: 'Activity not found',
                    statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
                );
            }

            return $this->errorResponse(
                message: 'An error occurred while retrieving the activity',
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
