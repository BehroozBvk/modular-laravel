<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Http\Requests\Api\V1\CreateTeacherRequest;
use Modules\Teacher\Services\TeacherService;

/**
 * @OA\Post(
 *     path="/teachers",
 *     tags={"Teachers"},
 *     summary="Create a new teacher",
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Teacher creation data",
 *
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "phone", "address", "city", "state", "zip", "country_id"},
 *             
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="address", type="string"),
 *             @OA\Property(property="city", type="string"),
 *             @OA\Property(property="state", type="string"),
 *             @OA\Property(property="zip", type="string"),
 *             @OA\Property(property="country_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer", nullable=true),
 *             @OA\Property(property="email", type="string", nullable=true),
 *             @OA\Property(property="password", type="string", nullable=true)
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Teacher created successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *             
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Teacher created successfully"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="first_name", type="string"),
 *                 @OA\Property(property="last_name", type="string"),
 *                 @OA\Property(property="phone", type="string"),
 *                 @OA\Property(property="address", type="string"),
 *                 @OA\Property(property="city", type="string"),
 *                 @OA\Property(property="state", type="string"),
 *                 @OA\Property(property="zip", type="string"),
 *                 @OA\Property(property="country_id", type="integer"),
 *                 @OA\Property(property="user_id", type="integer"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             ),
 *             @OA\Property(property="status_code", type="integer", example=201),
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
final class CreateTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(CreateTeacherRequest $request): JsonResponse
    {
        try {
            $teacher = $this->teacherService->createTeacher($request->toDto());

            return $this->successResponse(
                message: 'Teacher created successfully',
                statusCode: HttpStatusConstants::HTTP_201_CREATED,
                data: $teacher
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
