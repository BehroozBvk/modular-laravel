<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Student;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Student\RegisterStudentRequest;
use Modules\Auth\Http\Resources\Api\V1\Student\RegisterStudentResource;
use Modules\Auth\Services\Student\StudentAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/student/register",
 *     tags={"Student Auth"},
 *     summary="Register a new student",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/RegisterStudentRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Student registered successfully",
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
final class RegisterStudentController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentAuthService $studentAuthService
    ) {}

    public function __invoke(RegisterStudentRequest $request)
    {
        try {
            $student = $this->studentAuthService->register($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_REGISTERED),
                statusCode: HttpStatusConstants::HTTP_201_CREATED,
                data: new RegisterStudentResource($student)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::STUDENT_REGISTRATION_FAILED) . ' ' . $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
