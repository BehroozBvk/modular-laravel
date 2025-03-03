<?php

declare(strict_types=1);

namespace Modules\Student\Http\Controllers\Api\V1\Student;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Student\Http\Requests\Api\V1\Student\ListStudentsRequest;
use Modules\Student\Services\StudentService;

/**
 * @OA\Get(
 *     path="/api/v1/students",
 *     summary="List all students with pagination",
 *     description="Get a paginated list of students with optional filtering",
 *     operationId="listStudents",
 *     tags={"Students"},
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Search term for student name or email",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         description="Field to sort by",
 *         required=false,
 *         @OA\Schema(type="string", enum={"id", "first_name", "last_name", "email", "created_at", "updated_at"})
 *     ),
 *     @OA\Parameter(
 *         name="direction",
 *         in="query",
 *         description="Sort direction",
 *         required=false,
 *         @OA\Schema(type="string", enum={"asc", "desc"})
 *     ),
 *     @OA\Parameter(
 *         name="student_parent_id",
 *         in="query",
 *         description="Filter by student parent ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="active",
 *         in="query",
 *         description="Filter by active status",
 *         required=false,
 *         @OA\Schema(type="boolean")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number",
 *         required=false,
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Items per page",
 *         required=false,
 *         @OA\Schema(type="integer", default=15)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Student")),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Students retrieved successfully"),
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
class ListStudentsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentService $studentService
    ) {}

    public function __invoke(ListStudentsRequest $request): JsonResponse
    {
        try {
            $students = $this->studentService->getStudents($request->toDto());

            return $this->paginatedResponse($students);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
