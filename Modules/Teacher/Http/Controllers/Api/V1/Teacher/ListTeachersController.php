<?php

declare(strict_types=1);

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Teacher\Http\Requests\Api\V1\ListTeachersRequest;
use Modules\Teacher\Services\TeacherService;

/**
 * Controller for listing teachers with pagination and filtering.
 * 
 * @group Teachers
 * 
 * @subgroup Teacher Management
 */
final class ListTeachersController extends BaseApiV1Controller
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {}

    /**
     * List teachers
     * 
     * Get a paginated list of teachers with optional filtering.
     *
     * @queryParam per_page integer The number of items per page. Default: 15
     * @queryParam sort_by string The field to sort by (created_at|first_name|last_name). Default: created_at
     * @queryParam sort_direction string The sort direction (asc|desc). Default: desc
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Teachers retrieved successfully",
     *     "data": [
     *         {
     *             "id": 1,
     *             "first_name": "John",
     *             "last_name": "Doe",
     *             "phone": "+1234567890",
     *             "address": "123 Main St",
     *             "city": "New York",
     *             "state": "NY",
     *             "zip": "10001",
     *             "country_id": 1,
     *             "user_id": 1,
     *             "created_at": "2024-02-20T12:00:00Z",
     *             "updated_at": "2024-02-20T12:00:00Z",
     *             "user": {
     *                 "id": 1,
     *                 "email": "john.doe@example.com",
     *                 "type": "teacher",
     *                 "email_verified_at": "2024-02-20T12:00:00Z"
     *             },
     *             "country": {
     *                 "id": 1,
     *                 "name": "United States",
     *                 "code": "US",
     *                 "flag": "us.png"
     *             }
     *         }
     *     ],
     *     "meta": {
     *         "current_page": 1,
     *         "from": 1,
     *         "last_page": 1,
     *         "per_page": 15,
     *         "to": 1,
     *         "total": 1
     *     },
     *     "links": {
     *         "first": "http://localhost/api/v1/teachers?page=1",
     *         "last": "http://localhost/api/v1/teachers?page=1",
     *         "prev": null,
     *         "next": null
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     * 
     * @response 422 {
     *     "success": false,
     *     "message": "The given data was invalid",
     *     "errors": {
     *         "sort_by": ["The sort by field must be one of: created_at, first_name, last_name."],
     *         "sort_direction": ["The sort direction field must be one of: asc, desc."]
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     */
    public function __invoke(ListTeachersRequest $request): JsonResponse
    {
        try {
            $teachers = $this->teacherService->getTeachers($request->toDto());

            return $this->paginatedResponse(
                paginator: $teachers,
                message: 'Teachers retrieved successfully',
                statusCode: HttpStatusConstants::HTTP_200_OK
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
