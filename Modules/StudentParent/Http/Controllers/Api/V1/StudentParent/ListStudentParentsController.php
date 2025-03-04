<?php

declare(strict_types=1);

namespace Modules\StudentParent\Http\Controllers\Api\V1\StudentParent;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\StudentParent\DataTransferObjects\ListStudentParentDto;
use Modules\StudentParent\Http\Resources\Api\V1\StudentParentResource;
use Modules\StudentParent\Services\StudentParentService;

/**
 * Controller for listing student parents.
 * 
 * @group Student Parents
 * 
 * @subgroup Student Parent Management
 */
final class ListStudentParentsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly StudentParentService $studentParentService
    ) {}

    /**
     * List student parents
     * 
     * Get a paginated list of student parents with optional filtering and sorting.
     *
     * @queryParam per_page integer The number of items per page. Default: 15
     * @queryParam sort_by string The field to sort by. Default: created_at
     * @queryParam sort_direction string The direction to sort (asc or desc). Default: desc
     * 
     * @response 200 {
     *     "success": true,
     *     "message": "Student parents retrieved successfully",
     *     "data": {
     *         "current_page": 1,
     *         "data": [
     *             {
     *                 "id": 1,
     *                 "first_name": "John",
     *                 "last_name": "Doe",
     *                 "full_name": "John Doe",
     *                 "phone_number": "+1234567890",
     *                 "address": "123 Main St",
     *                 "city": "New York",
     *                 "state": "NY",
     *                 "zip": "10001",
     *                 "country_id": 1,
     *                 "user_id": 1,
     *                 "created_at": "2024-02-20T12:00:00Z",
     *                 "updated_at": "2024-02-20T12:00:00Z",
     *                 "user": {
     *                     "id": 1,
     *                     "email": "john.doe@example.com",
     *                     "type": "parent",
     *                     "email_verified_at": "2024-02-20T12:00:00Z"
     *                 },
     *                 "country": {
     *                     "id": 1,
     *                     "name": "United States",
     *                     "code": "US",
     *                     "flag": "us.png"
     *                 },
     *                 "students": [
     *                     {
     *                         "id": 1,
     *                         "first_name": "Jane",
     *                         "last_name": "Doe",
     *                         "full_name": "Jane Doe"
     *                     }
     *                 ]
     *             }
     *         ],
     *         "first_page_url": "http://example.com/api/v1/student-parents?page=1",
     *         "from": 1,
     *         "last_page": 1,
     *         "last_page_url": "http://example.com/api/v1/student-parents?page=1",
     *         "links": [
     *             {
     *                 "url": null,
     *                 "label": "&laquo; Previous",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/v1/student-parents?page=1",
     *                 "label": "1",
     *                 "active": true
     *             },
     *             {
     *                 "url": null,
     *                 "label": "Next &raquo;",
     *                 "active": false
     *             }
     *         ],
     *         "next_page_url": null,
     *         "path": "http://example.com/api/v1/student-parents",
     *         "per_page": 15,
     *         "prev_page_url": null,
     *         "to": 1,
     *         "total": 1
     *     },
     *     "timestamp": "2024-02-20T12:00:00Z"
     * }
     */
    public function __invoke(): JsonResponse
    {
        try {
            $studentParents = $this->studentParentService->getStudentParents(
                ListStudentParentDto::fromArray(request()->all())
            );

            return $this->successResponse(
                data: StudentParentResource::collection($studentParents),
                message: 'Student parents retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
