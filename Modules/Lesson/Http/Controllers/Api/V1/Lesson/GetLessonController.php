<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Resources\Api\V1\LessonResource;
use Modules\Lesson\Services\LessonService;

/**
 * @OA\Get(
 *     path="/api/v1/lessons/{id}",
 *     summary="Get a specific lesson by ID",
 *     description="Get details for a specific lesson including its progress",
 *     operationId="getLesson",
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
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/Lesson"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Lesson retrieved successfully"),
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
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class GetLessonController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            $lesson = $this->lessonService->findLesson($id);

            if (!$lesson) {
                return $this->errorResponse(
                    message: 'Lesson not found',
                    statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
                );
            }

            $lesson->load('progress');

            return $this->successResponse(
                data: new LessonResource($lesson),
                message: 'Lesson retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
