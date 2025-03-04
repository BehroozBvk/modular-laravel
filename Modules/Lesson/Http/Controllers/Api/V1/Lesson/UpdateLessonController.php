<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\UpdateLessonRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonResource;
use Modules\Lesson\Services\LessonService;

/**
 * @OA\Put(
 *     path="/api/v1/lessons/{id}",
 *     summary="Update an existing lesson",
 *     description="Update an existing lesson with the provided data",
 *     operationId="updateLesson",
 *     tags={"Lessons"},
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Lesson ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Lesson data to update",
 *         @OA\JsonContent(
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
 *         response=200,
 *         description="Lesson updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/Lesson"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Lesson updated successfully"),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Lesson not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
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
final class UpdateLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    public function __invoke(UpdateLessonRequest $request, int $id): JsonResponse
    {
        try {
            $lesson = $this->lessonService->findLesson($id);

            if (!$lesson) {
                return $this->errorResponse(
                    message: 'Lesson not found',
                    statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
                );
            }

            $updated = $this->lessonService->updateLesson($id, $request->toDto());

            if (!$updated) {
                return $this->errorResponse(
                    message: 'Failed to update lesson',
                    statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
                );
            }

            // Refresh the lesson instance to get updated data
            $lesson = $this->lessonService->findLesson($id);
            $lesson->load('progress');

            return $this->successResponse(
                data: new LessonResource($lesson),
                message: 'Lesson updated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
