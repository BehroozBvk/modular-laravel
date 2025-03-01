<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Teacher\LoginTeacherRequest;
use Modules\Auth\Http\Resources\Api\V1\Teacher\LoginTeacherResource;
use Modules\Auth\Services\Teacher\TeacherAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/teacher/login",
 *     tags={"Teacher Auth"},
 *     summary="Login a teacher",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/LoginTeacherRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Teacher logged in successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
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
final class LoginTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherAuthService $teacherAuthService
    ) {}

    public function __invoke(LoginTeacherRequest $request): JsonResponse
    {
        try {
            $token = $this->teacherAuthService->login($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::TEACHER_LOGGED_IN),
                data: new LoginTeacherResource($token)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_401_UNAUTHORIZED
            );
        }
    }
}
