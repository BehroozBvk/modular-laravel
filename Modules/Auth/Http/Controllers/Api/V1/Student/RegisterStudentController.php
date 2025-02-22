<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Auth\{
    Http\Requests\Api\V1\Student\RegisterStudentRequest,
    Http\Resources\Api\V1\Student\RegisterStudentResource,
    Services\Student\StudentAuthService
};

final class RegisterStudentController extends Controller
{
    public function __construct(
        private readonly StudentAuthService $studentAuthService
    ) {}

    public function __invoke(RegisterStudentRequest $request): JsonResponse
    {
        try {
            $student = $this->studentAuthService->register($request->toDto());

            return response()->json([
                'message' => 'Student registered successfully!',
                'data' => new RegisterStudentResource($student)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to register student.'
            ], 500);
        }
    }
}
