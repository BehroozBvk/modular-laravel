<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Progress;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\ListLessonProgressRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonProgressResource;
use Modules\Lesson\Services\LessonProgressService;

/**
 * @OA\Get(
 *     path="/api/v1/lesson-progress",
 *     summary="List all lesson progress records with pagination",
 *     description="Get a paginated list of lesson progress records with optional filtering",
 *     operationId="listProgress",
 *     tags={"Lesson Progress"},
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Items per page",
 *         required=false,
 *         @OA\Schema(type="integer", default=15)
 *     ),
 *     @OA\Parameter(
 *         name="sort_by",
 *         in="query",
 *         description="Field to sort by",
 *         required=false,
 *         @OA\Schema(type="string", enum={"created_at", "memorization_level", "recitation_quality", "mistakes_count"}, default="created_at")
 *     ),
 *     @OA\Parameter(
 *         name="sort_direction",
 *         in="query",
 *         description="Sort direction",
 *         required=false,
 *         @OA\Schema(type="string", enum={"asc", "desc"}, default="desc")
 *     ),
 *     @OA\Parameter(
 *         name="lesson_id",
 *         in="query",
 *         description="Filter by lesson ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="student_id",
 *         in="query",
 *         description="Filter by student ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/LessonProgress")),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Progress records retrieved successfully"),
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
final class ListProgressController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonProgressService $progressService
    ) {}

    public function __invoke(ListLessonProgressRequest $request): JsonResponse
    {
        try {
            $progressRecords = $this->progressService->getProgressRecords($request->toDto());

            return $this->paginatedResponse(
                $progressRecords,
                LessonProgressResource::class,
                'Progress records retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
