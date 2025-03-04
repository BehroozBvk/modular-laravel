<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Services\LessonService;

/**
 * Controller for deleting a lesson.
 * 
 * @group Lessons
 * 
 * @subgroup Lesson Management
 */
final class DeleteLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * Delete a lesson
     * 
     * Delete a specific lesson by its ID.
     *
     * @urlParam id integer required The ID of the lesson to delete. Example: 1
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Lesson deleted successfully",
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @response 404 {
     *     "success": false,
     *     "message": "Lesson not found",
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @throws Exception When lesson is not found or deletion fails
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->lessonService->deleteLesson($id);

            return $this->successResponse(
                message: 'Lesson deleted successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
