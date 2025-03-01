<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Teacher;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Teacher\VerifyEmailTeacherRequest;
use Modules\Auth\Services\Teacher\TeacherAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/teacher/verify-email/{id}/{hash}",
 *     tags={"Teacher Auth"},
 *     summary="Verify teacher's email address",
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Teacher ID",
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Parameter(
 *         name="hash",
 *         in="path",
 *         required=true,
 *         description="Email verification hash",
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Email verified successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Invalid verification link",
 *
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Teacher not found",
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
final class VerifyEmailTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherAuthService $teacherAuthService
    ) {}

    public function __invoke(VerifyEmailTeacherRequest $request)
    {
        try {
            $this->teacherAuthService->verifyEmail($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::TEACHER_EMAIL_VERIFIED)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
