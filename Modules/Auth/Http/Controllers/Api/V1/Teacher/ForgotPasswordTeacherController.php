<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Teacher;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\Teacher\ForgotPasswordTeacherRequest,
    Services\Teacher\TeacherAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/teacher/forgot-password",
 *     tags={"Teacher Auth"},
 *     summary="Send password reset link to teacher's email",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ForgotPasswordTeacherRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset link sent successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Teacher not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class ForgotPasswordTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherAuthService $teacherAuthService
    ) {}

    public function __invoke(ForgotPasswordTeacherRequest $request)
    {
        try {
            $this->teacherAuthService->sendPasswordResetLink($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::TEACHER_PASSWORD_RESET_LINK_SENT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
