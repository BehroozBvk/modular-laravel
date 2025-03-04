<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\CreateLessonRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonResource;
use Modules\Lesson\Services\LessonService;

/**
 * Controller for creating a new lesson.
 * 
 * @group Lessons
 * 
 * @subgroup Lesson Management
 */
final class CreateLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * Create a lesson
     * 
     * Create a new lesson with the provided data.
     *
     * @bodyParam teacher_id integer required The ID of the teacher. Example: 1
     * @bodyParam student_id integer required The ID of the student. Example: 2
     * @bodyParam surah string required The name of the surah. Example: Al-Fatihah
     * @bodyParam ayah_from integer required The starting ayah number. Example: 1
     * @bodyParam ayah_to integer required The ending ayah number. Example: 7
     * @bodyParam date date required The date of the lesson (Y-m-d). Example: 2024-02-20
     * @bodyParam homework string optional The homework assignment. Example: Memorize verses 1-7
     * @bodyParam feedback string optional The teacher's feedback. Example: Good progress
     * 
     * @response 201 {
     *     "success": true,
     *     "message": "Lesson created successfully",
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
     * @response 422 {
     *     "success": false,
     *     "message": "The given data was invalid",
     *     "errors": {
     *         "teacher_id": ["The teacher id field is required."],
     *         "student_id": ["The student id field is required."],
     *         "surah": ["The surah field is required."],
     *         "ayah_from": ["The ayah from field is required."],
     *         "ayah_to": ["The ayah to field is required."],
     *         "date": ["The date field is required."]
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @throws Exception When lesson creation fails
     */
    public function __invoke(CreateLessonRequest $request): JsonResponse
    {
        try {
            $lesson = $this->lessonService->createLesson($request->toDto());

            return $this->successResponse(
                data: new LessonResource($lesson),
                message: 'Lesson created successfully',
                statusCode: HttpStatusConstants::HTTP_201_CREATED
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
