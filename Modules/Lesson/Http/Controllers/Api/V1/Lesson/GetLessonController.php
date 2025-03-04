<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Resources\Api\V1\LessonResource;
use Modules\Lesson\Services\LessonService;

/**
 * Controller for retrieving a specific lesson.
 * 
 * @group Lessons
 * 
 * @subgroup Lesson Management
 */
final class GetLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * Get a lesson
     * 
     * Retrieve a specific lesson by its ID including its progress records.
     *
     * @urlParam id integer required The ID of the lesson to retrieve. Example: 1
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Lesson retrieved successfully",
     *     "data": {
     *         "id": 1,
     *         "teacher_id": 1,
     *         "student_id": 2,
     *         "surah": "Al-Fatihah",
     *         "ayah_from": 1,
     *         "ayah_to": 7,
     *         "date": "2024-02-20",
     *         "homework": "Memorize verses 1-7",
     *         "feedback": "Good progress",
     *         "created_at": "2024-02-20T12:00:00Z",
     *         "updated_at": "2024-02-20T12:00:00Z",
     *         "progress": []
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @response 404 {
     *     "success": false,
     *     "message": "Lesson not found",
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @throws Exception When lesson is not found
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $lesson = $this->lessonService->findLessonOrFail($id);
            $lesson->load('progress');

            return $this->successResponse(
                data: new LessonResource($lesson),
                message: 'Lesson retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
