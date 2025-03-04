<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Services\TeacherService;

/**
 * Controller for deleting a teacher.
 * 
 * @group Teachers
 * 
 * @subgroup Teacher Management
 */
final class DeleteTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    /**
     * Delete a teacher
     * 
     * Delete a specific teacher by their ID.
     *
     * @urlParam id integer required The ID of the teacher to delete. Example: 1
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Teacher deleted successfully",
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @response 404 {
     *     "success": false,
     *     "message": "Teacher not found",
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->teacherService->deleteTeacher($id);

            return $this->successResponse(
                message: 'Teacher deleted successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
