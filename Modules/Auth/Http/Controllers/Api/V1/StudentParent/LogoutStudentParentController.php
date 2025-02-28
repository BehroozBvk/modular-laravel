<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

/**
 * @OA\Post(
 *     path="/auth/student-parents/logout",
 *     tags={"Student Parent Auth"},
 *     summary="Logout a student parent",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Student parent logged out successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class LogoutStudentParentController extends BaseApiV1Controller
{
    public function __invoke()
    {
        try {
            request()->user()->token()->revoke();

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_LOGGED_OUT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
