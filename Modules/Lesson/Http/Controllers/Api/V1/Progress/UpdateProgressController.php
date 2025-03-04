<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Progress;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\UpdateLessonProgressRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonProgressResource;
use Modules\Lesson\Services\LessonProgressService;

/**
 * @OA\Put(
 *     path="/api/v1/lesson-progress/{id}",
 *     summary="Update an existing progress record",
 *     description="Update an existing progress record with the provided data",
 *     operationId="updateProgress",
 *     tags={"Lesson Progress"},
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Progress record ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Progress data to update",
 *         @OA\JsonContent(
 *             @OA\Property(property="memorization_level", type="integer", example=8, description="Scale of 1-10"),
 *             @OA\Property(property="recitation_quality", type="integer", example=7, description="Scale of 1-10"),
 *             @OA\Property(property="mistakes_count", type="integer", example=3),
 *             @OA\Property(property="notes", type="string", example="Made good improvement", nullable=true)
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Progress record updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/LessonProgress"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Progress record updated successfully"),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Progress record not found",
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
final class UpdateProgressController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonProgressService $progressService
    ) {}

    public function __invoke(UpdateLessonProgressRequest $request, int $id): JsonResponse
    {
        try {
            $updatedProgress = $this->progressService->updateProgressRecord($id, $request->toDto());

            return $this->successResponse(
                data: new LessonProgressResource($updatedProgress),
                message: 'Progress record updated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
