<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Constants\Messages\CoreMessageConstants;
use Modules\Core\Helpers\ApiResponse;
use Modules\Core\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Operation successful"),
 *     @OA\Property(property="data", type="object", nullable=true),
 *     @OA\Property(property="status_code", type="integer", example=200),
 *     @OA\Property(property="timestamp", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Operation failed"),
 *     @OA\Property(property="errors", type="object", nullable=true),
 *     @OA\Property(property="status_code", type="integer", example=400),
 *     @OA\Property(property="timestamp", type="string", format="date-time")
 * )
 */
abstract class BaseApiController extends Controller
{
    public function __construct(private readonly Request $request) {}

    /**
     * Returns a paginated response
     *
     * @template T
     *
     * @param  LengthAwarePaginator<T>  $paginator
     * @return JsonResponse<array{
     *     success: true,
     *     message: string,
     *     data: array<int, T>,
     *     meta: array{
     *         current_page: int,
     *         from: int|null,
     *         last_page: int,
     *         per_page: int,
     *         to: int|null,
     *         total: int,
     *     },
     *     status_code: int,
     *     timestamp: string
     * }>
     */
    protected function paginatedResponse(
        LengthAwarePaginator $paginator,
        ?string $message = null,
        int $statusCode = HttpStatusConstants::HTTP_200_OK,
    ): JsonResponse {
        return $this->successResponse(
            message: $message,
            statusCode: $statusCode,
            data: [
                'data' => $paginator->items(),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'from' => $paginator->firstItem(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'to' => $paginator->lastItem(),
                    'total' => $paginator->total(),
                ],
            ],
        );
    }

    /**
     * Returns a success response with optional data
     *
     * @template TResponseData
     *
     * @param  string|null  $message  Custom success message
     * @param  int  $statusCode  HTTP status code
     * @param  TResponseData|null  $data  Response data
     * @return JsonResponse<array{
     *   success: true,
     *   message: string,
     *   data: TResponseData|null,
     *   status_code: int,
     *   timestamp: string
     * }>
     */
    protected function successResponse(
        ?string $message = null,
        int $statusCode = HttpStatusConstants::HTTP_200_OK,
        mixed $data = null,
    ): JsonResponse {
        return ApiResponse::success(
            message: $message ?? CoreMessageConstants::get(CoreMessageConstants::GENERIC_SUCCESS),
            statusCode: $statusCode,
            data: $data,
        );
    }

    /**
     * Returns an error response with optional error data
     *
     * @template TErrorData
     *
     * @param  string|null  $message  Custom error message
     * @param  int  $statusCode  HTTP status code
     * @param  TErrorData|null  $data  Error data
     * @return JsonResponse<array{
     *   success: false,
     *   message: string,
     *   errors: TErrorData|null,
     *   status_code: int,
     *   timestamp: string
     * }>
     */
    protected function errorResponse(
        ?string $message = null,
        int $statusCode = HttpStatusConstants::HTTP_400_BAD_REQUEST,
        mixed $data = null,
    ): JsonResponse {
        return ApiResponse::error(
            message: $message ?? CoreMessageConstants::get(CoreMessageConstants::GENERIC_ERROR),
            statusCode: $statusCode,
            data: $data,
        );
    }
}
