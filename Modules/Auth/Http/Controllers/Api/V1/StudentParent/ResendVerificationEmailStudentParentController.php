<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\StudentParent\ResendVerificationEmailStudentParentRequest,
    Services\StudentParent\StudentParentAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/student-parents/resend-verification-email",
 *     tags={"Student Parent Auth"},
 *     summary="Resend verification email to student parent",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ResendVerificationEmailStudentParentRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Verification email sent successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Email already verified",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Student parent not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class ResendVerificationEmailStudentParentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentParentAuthService $studentParentAuthService
    ) {}

    public function __invoke(ResendVerificationEmailStudentParentRequest $request)
    {
        try {
            $this->studentParentAuthService->resendVerificationEmail($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_VERIFICATION_EMAIL_SENT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
