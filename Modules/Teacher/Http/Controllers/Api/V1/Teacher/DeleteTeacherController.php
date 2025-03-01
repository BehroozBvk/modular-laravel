<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Services\TeacherService;

/**
 * @OA\Delete(
 *     path="/teachers/{id}",
 *     tags={"Teachers"},
 *     summary="Delete a teacher",
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
 *     @OA\Response(
 *         response=200,
 *         description="Teacher deleted successfully",
 *
 *         @OA\JsonContent(
 *             type="object",
 *             
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Teacher deleted successfully"),
 *             @OA\Property(property="data", type="null"),
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="timestamp", type="string", format="date-time")
 *         )
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
final class DeleteTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        try {
            $success = $this->teacherService->deleteTeacher($id);

            if (! $success) {
                return $this->errorResponse(
                    message: 'Teacher not found',
                    statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
                );
            }

            return $this->successResponse(
                message: 'Teacher deleted successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
