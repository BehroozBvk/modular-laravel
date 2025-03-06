<?php

declare(strict_types=1);

namespace Modules\Activity\Http\Controllers\Api\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Activity\Http\Resources\Api\V1\ActivityResource;
use Modules\Activity\Services\ActivityService;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;

/**
 * @group Activity Management
 *
 * APIs for managing activities
 */
final class ListActivitiesController extends BaseApiV1Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ActivityService $activityService
    ) {}

    /**
     * List all activities
     *
     * This endpoint retrieves all activities.
     *
     * @response status=200 scenario="Success" {
     *     "status": "success",
     *     "message": "Activities retrieved successfully",
     *     "data": [
     *         {
     *             "id": 1,
     *             "slug": "summer-coding-camp",
     *             "main_image": "https://example.com/images/main.jpg",
     *             "cover_image": "https://example.com/images/cover.jpg",
     *             "video": "https://example.com/videos/intro.mp4",
     *             "activity_time": "2025-06-15 10:00:00",
     *             "alt_image": "https://example.com/images/alt.jpg",
     *             "points": 10,
     *             "title": "Summer Coding Camp",
     *             "short_description": "Learn coding in a fun environment",
     *             "category": "Programming",
     *             "description": "A comprehensive coding camp for beginners",
     *             "activity_type": "Camp",
     *             "meta_title": "Summer Coding Camp | Learn to Code",
     *             "meta_description": "Join our summer coding camp and learn to code in a fun environment",
     *             "meta_tags": "coding, camp, summer, programming",
     *             "created_at": "2025-03-01 12:00:00",
     *             "updated_at": "2025-03-01 12:00:00"
     *         }
     *     ]
     * }
     *
     * @response status=500 scenario="Server Error" {
     *     "status": "error",
     *     "message": "An error occurred while retrieving activities",
     *     "data": null
     * }
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $activities = $this->activityService->getAllActivities();

            return $this->successResponse(
                data: ActivityResource::collection($activities),
                message: 'Activities retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: 'An error occurred while retrieving activities',
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
