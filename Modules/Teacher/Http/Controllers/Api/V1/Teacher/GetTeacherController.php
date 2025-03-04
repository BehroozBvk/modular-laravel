<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Http\Resources\Api\V1\TeacherResource;
use Modules\Teacher\Services\TeacherService;

/**
 * Controller for retrieving a specific teacher.
 * 
 * @group Teachers
 * 
 * @subgroup Teacher Management
 */
final class GetTeacherController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    /**
     * Get a teacher
     * 
     * Retrieve a specific teacher by their ID including their user and country information.
     *
     * @urlParam id integer required The ID of the teacher to retrieve. Example: 1
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Teacher retrieved successfully",
     *     "data": {
     *         "id": 1,
     *         "first_name": "John",
     *         "last_name": "Doe",
     *         "full_name": "John Doe",
     *         "phone_number": "+1234567890",
     *         "address": "123 Main St",
     *         "city": "New York",
     *         "state": "NY",
     *         "zip": "10001",
     *         "country_id": 1,
     *         "user_id": 1,
     *         "created_at": "2024-02-20T12:00:00Z",
     *         "updated_at": "2024-02-20T12:00:00Z",
     *         "deleted_at": null,
     *         "user": {
     *             "id": 1,
     *             "email": "john.doe@example.com",
     *             "type": "teacher",
     *             "email_verified_at": "2024-02-20T12:00:00Z"
     *         },
     *         "country": {
     *             "id": 1,
     *             "name": "United States",
     *             "code": "US",
     *             "flag": "us.png"
     *         }
     *     },
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
            $teacher = $this->teacherService->findTeacherOrFail($id);
            $teacher->load(['user', 'country']);

            return $this->successResponse(
                data: new TeacherResource($teacher),
                message: 'Teacher retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
