<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\StudentParent\RegisterStudentParentRequest;
use Modules\Auth\Http\Resources\Api\V1\StudentParent\RegisterStudentParentResource;
use Modules\Auth\Services\StudentParent\StudentParentAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/student-parents/register",
 *     tags={"Student Parent Auth"},
 *     summary="Register a new student parent",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/RegisterStudentParentRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Student parent registered successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
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
final class RegisterStudentParentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentParentAuthService $studentParentAuthService
    ) {}

    public function __invoke(RegisterStudentParentRequest $request)
    {
        try {
            $studentParent = $this->studentParentAuthService->register($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_REGISTERED),
                statusCode: HttpStatusConstants::HTTP_201_CREATED,
                data: new RegisterStudentParentResource($studentParent)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_REGISTRATION_FAILED) . ' ' . $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
