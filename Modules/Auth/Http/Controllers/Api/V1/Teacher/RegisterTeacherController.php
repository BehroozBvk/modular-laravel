<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Teacher;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\Teacher\RegisterTeacherRequest,
    Http\Resources\Api\V1\Teacher\RegisterTeacherResource,
    Services\Teacher\TeacherAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/teacher/register",
 *     tags={"Teacher Auth"},
 *     summary="Register a new teacher",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/RegisterTeacherRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Teacher registered successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class RegisterTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherAuthService $teacherAuthService
    ) {}

    public function __invoke(RegisterTeacherRequest $request)
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
                message: AuthMessageConstants::get(AuthMessageConstants::TEACHER_REGISTRATION_FAILED),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
