<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\StudentParent\VerifyEmailStudentParentRequest,
    Services\StudentParent\StudentParentAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/student-parents/verify-email/{id}/{hash}",
 *     tags={"Student Parent Auth"},
 *     summary="Verify student parent's email address",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Student Parent ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="hash",
 *         in="path",
 *         required=true,
 *         description="Email verification hash",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Email verified successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid verification link",
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
final class VerifyEmailStudentParentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentParentAuthService $studentParentAuthService
    ) {}

    public function __invoke(VerifyEmailStudentParentRequest $request)
    {
        try {
            $this->studentParentAuthService->verifyEmail($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_EMAIL_VERIFIED)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
