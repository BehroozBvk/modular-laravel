<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\StudentParent\ResetPasswordStudentParentRequest,
    Services\StudentParent\StudentParentAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/student-parent/reset-password",
 *     tags={"Student Parent Auth"},
 *     summary="Reset student parent's password",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ResetPasswordStudentParentRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid token",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Student not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class ResetPasswordStudentParentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentParentAuthService $studentParentAuthService
    ) {}

    public function __invoke(ResetPasswordStudentParentRequest $request)
    {
        try {
            $this->studentParentAuthService->resetPassword($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PASSWORD_RESET_SUCCESS)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
