<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Teacher;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Teacher\RegisterTeacherRequest;
use Modules\Auth\Http\Resources\Api\V1\Teacher\RegisterTeacherResource;
use Modules\Auth\Services\Teacher\TeacherAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/teacher/register",
 *     tags={"Teacher Auth"},
 *     summary="Register a new teacher",
 *
 *     @OA\RequestBody(
 *         required=true,
 *         description="Teacher registration data",
 *
 *         @OA\JsonContent(
 *             required={"email", "password", "first_name", "last_name", "phone", "address", "city", "state", "zip", "country_id"},
 *             
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string", minLength=8),
 *             @OA\Property(property="first_name", type="string", maxLength=255),
 *             @OA\Property(property="last_name", type="string", maxLength=255),
 *             @OA\Property(property="phone", type="string", maxLength=255),
 *             @OA\Property(property="address", type="string", maxLength=255),
 *             @OA\Property(property="city", type="string", maxLength=255),
 *             @OA\Property(property="state", type="string", maxLength=255),
 *             @OA\Property(property="zip", type="string", maxLength=255),
 *             @OA\Property(property="country_id", type="integer", description="ID of the country")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Teacher registered successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *             
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Teacher registered successfully"),
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
 *                 @OA\Property(property="updated_at", type="string", format="date-time"),
 *                 @OA\Property(property="user", type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="type", type="string", enum={"teacher"}),
 *                     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true)
 *                 )
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
final class RegisterTeacherController extends BaseApiV1Controller
{
    /**
     * RegisterTeacherController constructor.
     *
     * @param TeacherAuthService $teacherAuthService
     */
    public function __construct(
        private readonly TeacherAuthService $teacherAuthService
    ) {}

    /**
     * Handle the incoming request to register a new teacher.
     *
     * @param RegisterTeacherRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterTeacherRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $teacher = $this->teacherAuthService->register($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::TEACHER_REGISTERED),
                statusCode: HttpStatusConstants::HTTP_201_CREATED,
                data: new RegisterTeacherResource($teacher)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
