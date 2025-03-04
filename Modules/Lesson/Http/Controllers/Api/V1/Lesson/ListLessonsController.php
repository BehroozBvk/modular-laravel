<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\ListLessonsRequest;
use Modules\Lesson\Services\LessonService;

/**
 * Controller for listing lessons with pagination and filtering.
 * 
 * @group Lessons
 * 
 * @subgroup Lesson Management
 */
final class ListLessonsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * List lessons
     * 
     * Get a paginated list of lessons with optional filtering.
     *
     * @queryParam per_page integer The number of items per page. Default: 15
     * @queryParam sort_by string The field to sort by (date|created_at|student_id|teacher_id). Default: date
     * @queryParam sort_direction string The sort direction (asc|desc). Default: desc
     * @queryParam student_id integer Filter lessons by student ID. Example: 1
     * @queryParam teacher_id integer Filter lessons by teacher ID. Example: 1
     * @queryParam date date Filter lessons by date (Y-m-d). Example: 2024-02-20
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Lessons retrieved successfully",
     *     "data": [
     *         {
     *             "id": 1,
     *             "teacher_id": 1,
     *             "student_id": 2,
     *             "surah": "Al-Fatihah",
     *             "ayah_from": 1,
     *             "ayah_to": 7,
     *             "date": "2024-02-20",
     *             "homework": "Memorize verses 1-7",
     *             "feedback": "Good progress",
     *             "created_at": "2024-02-20T12:00:00Z",
     *             "updated_at": "2024-02-20T12:00:00Z",
     *             "progress": []
     *         }
     *     ],
     *     "meta": {
     *         "current_page": 1,
     *         "from": 1,
     *         "last_page": 1,
     *         "per_page": 15,
     *         "to": 1,
     *         "total": 1
     *     },
     *     "links": {
     *         "first": "http://localhost/api/v1/lessons?page=1",
     *         "last": "http://localhost/api/v1/lessons?page=1",
     *         "prev": null,
     *         "next": null
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @response 422 {
     *     "success": false,
     *     "message": "The given data was invalid",
     *     "errors": {
     *         "sort_by": ["The sort by field must be one of: date, created_at, student_id, teacher_id."],
     *         "sort_direction": ["The sort direction field must be one of: asc, desc."]
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     */
    public function __invoke(ListLessonsRequest $request): JsonResponse
    {
        try {
            $lessons = $this->lessonService->getLessons($request->toDto());

            return $this->paginatedResponse(
                paginator: $lessons,
                message: 'Lessons retrieved successfully',
                statusCode: HttpStatusConstants::HTTP_200_OK
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
