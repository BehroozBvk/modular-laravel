<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Http\Requests\Api\V1\ListTeachersRequest;
use Modules\Teacher\Services\TeacherService;

/**
 * @OA\Get(
 *     path="/teachers",
 *     tags={"Teachers"},
 *     summary="List all teachers",
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number",
 *         required=false,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Items per page (1-100)",
 *         required=false,
 *
 *         @OA\Schema(type="integer", minimum=1, maximum=100)
 *     ),
 *
 *     @OA\Parameter(
 *         name="sort_by",
 *         in="query",
 *         description="Sort by field (created_at, first_name, last_name)",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"created_at", "first_name", "last_name"})
 *     ),
 *
 *     @OA\Parameter(
 *         name="sort_direction",
 *         in="query",
 *         description="Sort direction",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"asc", "desc"})
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="List of teachers",
 *
 *         @OA\JsonContent(
 *             type="object",
 *             
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Operation successful"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="items", type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         
 *                         @OA\Property(property="id", type="integer"),
 *                         @OA\Property(property="first_name", type="string"),
 *                         @OA\Property(property="last_name", type="string"),
 *                         @OA\Property(property="phone", type="string"),
 *                         @OA\Property(property="address", type="string"),
 *                         @OA\Property(property="city", type="string"),
 *                         @OA\Property(property="state", type="string"),
 *                         @OA\Property(property="zip", type="string"),
 *                         @OA\Property(property="country_id", type="integer"),
 *                         @OA\Property(property="user_id", type="integer"),
 *                         @OA\Property(property="created_at", type="string", format="date-time"),
 *                         @OA\Property(property="updated_at", type="string", format="date-time"),
 *                         @OA\Property(property="user", type="object",
 *                             @OA\Property(property="id", type="integer"),
 *                             @OA\Property(property="email", type="string"),
 *                             @OA\Property(property="type", type="string"),
 *                             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true)
 *                         ),
 *                         @OA\Property(property="country", type="object",
 *                             @OA\Property(property="id", type="integer"),
 *                             @OA\Property(property="name", type="string"),
 *                             @OA\Property(property="code", type="string"),
 *                             @OA\Property(property="flag", type="string")
 *                         )
 *                     )
 *                 ),
 *                 
 *                 @OA\Property(property="meta", type="object",
 *                     @OA\Property(property="current_page", type="integer"),
 *                     @OA\Property(property="from", type="integer"),
 *                     @OA\Property(property="last_page", type="integer"),
 *                     @OA\Property(property="per_page", type="integer"),
 *                     @OA\Property(property="to", type="integer"),
 *                     @OA\Property(property="total", type="integer")
 *                 )
 *             ),
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class ListTeachersController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(ListTeachersRequest $request): JsonResponse
    {
        try {
            $teachers = $this->teacherService->getTeachers($request->toDto());

            return $this->paginatedResponse($teachers);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
