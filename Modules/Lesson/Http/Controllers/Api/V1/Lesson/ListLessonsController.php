<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\ListLessonsRequest;
use Modules\Lesson\Http\Resources\Api\V1\LessonResource;
use Modules\Lesson\Services\LessonService;

/**
 * Controller for listing lessons with pagination and filtering.
 *
 * @OA\Get(
 *     path="/api/v1/lessons",
 *     summary="List all lessons with pagination",
 *     description="Get a paginated list of lessons with optional filtering",
 *     operationId="listLessons",
 *     tags={"Lessons"},
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
 *         @OA\Schema(type="string", enum={"date", "created_at", "student_id", "teacher_id"}, default="date")
 *     ),
 *     @OA\Parameter(
 *         name="sort_direction",
 *         in="query",
 *         description="Sort direction",
 *         required=false,
 *         @OA\Schema(type="string", enum={"asc", "desc"}, default="desc")
 *     ),
 *     @OA\Parameter(
 *         name="student_id",
 *         in="query",
 *         description="Filter by student ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="teacher_id",
 *         in="query",
 *         description="Filter by teacher ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="date",
 *         in="query",
 *         description="Filter by date (Y-m-d)",
 *         required=false,
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lesson")),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Lessons retrieved successfully"),
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
final class ListLessonsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    /**
     * Handle the incoming request to list lessons.
     *
     * @param ListLessonsRequest $request The validated request containing filter and pagination parameters.
     * @return JsonResponse The JSON response containing the paginated lessons data.
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
