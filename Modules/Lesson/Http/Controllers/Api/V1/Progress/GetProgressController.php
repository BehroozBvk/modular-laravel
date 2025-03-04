<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Progress;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Resources\Api\V1\LessonProgressResource;
use Modules\Lesson\Services\LessonProgressService;

/**
 * @OA\Get(
 *     path="/api/v1/lesson-progress/{id}",
 *     summary="Get a specific progress record by ID",
 *     description="Get details for a specific lesson progress record",
 *     operationId="getProgress",
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
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", ref="#/components/schemas/LessonProgress"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Progress record retrieved successfully"),
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
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class GetProgressController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonProgressService $progressService
    ) {}

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            $progress = $this->progressService->findProgressRecord($id);

            if (!$progress) {
                return $this->errorResponse(
                    message: 'Progress record not found',
                    statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
                );
            }

            return $this->successResponse(
                data: new LessonProgressResource($progress),
                message: 'Progress record retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
