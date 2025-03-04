<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Progress;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\CreateLessonProgressRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonProgressResource;
use Modules\Lesson\Services\LessonProgressService;

/**
 * @OA\Post(
 *     path="/api/v1/lesson-progress",
 *     summary="Create a new lesson progress record",
 *     description="Create a new progress record for tracking student achievement",
 *     operationId="createProgress",
 *     tags={"Lesson Progress"},
 *     security={{"passport": {}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Progress data",
 *         @OA\JsonContent(
 *             required={"lesson_id", "student_id", "memorization_level", "recitation_quality", "mistakes_count"},
 *             @OA\Property(property="lesson_id", type="integer", example=1),
 *             @OA\Property(property="student_id", type="integer", example=2),
 *             @OA\Property(property="memorization_level", type="integer", example=8, description="Scale of 1-10"),
 *             @OA\Property(property="recitation_quality", type="integer", example=7, description="Scale of 1-10"),
 *             @OA\Property(property="mistakes_count", type="integer", example=3),
 *             @OA\Property(property="notes", type="string", example="Good progress on memorization", nullable=true)
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Progress record created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/LessonProgress"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Progress record created successfully"),
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
final class CreateProgressController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonProgressService $progressService
    ) {}

    public function __invoke(CreateLessonProgressRequest $request): JsonResponse
    {
        try {
            $progress = $this->progressService->createProgressRecord($request->toDto());

            return $this->successResponse(
                data: new LessonProgressResource($progress),
                message: 'Progress record created successfully',
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
