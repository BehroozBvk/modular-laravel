<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Student;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Student\LoginStudentRequest;
use Modules\Auth\Http\Resources\Api\V1\Student\LoginStudentResource;
use Modules\Auth\Services\Student\StudentAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/student/login",
 *     tags={"Student Auth"},
 *     summary="Login a student",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/LoginStudentRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Student logged in successfully",
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
final class LoginStudentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentAuthService $studentAuthService
    ) {}

    public function __invoke(LoginStudentRequest $request)
    {
        try {
            $token = $this->studentAuthService->login($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_LOGGED_IN),
                data: new LoginStudentResource($token)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_401_UNAUTHORIZED
            );
        }
    }
}
