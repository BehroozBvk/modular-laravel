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
 * @OA\Post(
 *     path="/api/v1/lessons",
 *     summary="Create a new lesson",
 *     description="Create a new lesson with the provided data",
 *     operationId="createLesson",
 *     tags={"Lessons"},
 *     security={{"passport": {}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Lesson data",
 *         @OA\JsonContent(
 *             required={"teacher_id", "student_id", "surah", "ayah_from", "ayah_to", "date"},
 *             @OA\Property(property="teacher_id", type="integer", example=1),
 *             @OA\Property(property="student_id", type="integer", example=2),
 *             @OA\Property(property="surah", type="string", example="Al-Fatihah"),
 *             @OA\Property(property="ayah_from", type="integer", example=1),
 *             @OA\Property(property="ayah_to", type="integer", example=7),
 *             @OA\Property(property="date", type="string", format="date", example="2023-06-01"),
 *             @OA\Property(property="homework", type="string", example="Memorize verses 1-7", nullable=true),
 *             @OA\Property(property="feedback", type="string", example="Good progress", nullable=true)
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Lesson created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/Lesson"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Lesson created successfully"),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class CreateLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

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
