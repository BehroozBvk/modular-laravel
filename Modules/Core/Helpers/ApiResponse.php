<?php

declare(strict_types=1);

namespace Modules\Core\Helpers;

use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Constants\Messages\CoreMessageConstants;

/**
 * Helper class for standardized API responses
 * 
 * @template TData
 * @template TError
 */
final class ApiResponse
{
    /**
     * Create a success response
     *
     * @template T
     * @param string|null $message Custom success message
     * @param int $statusCode HTTP status code
     * @param T|null $data Response payload data
     * @return JsonResponse<array{
     *   success: true,
     *   message: string,
     *   data: T|null,
     *   status_code: int,
     *   timestamp: string
     * }>
     */
    public static function success(
        string $message = null,
        int $statusCode = HttpStatusConstants::HTTP_200_OK,
        mixed $data = null
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message ?? CoreMessageConstants::get(CoreMessageConstants::GENERIC_SUCCESS),
            'data' => $data,
            'status_code' => $statusCode,
            'timestamp' => now()->toIso8601String(),
        ], $statusCode);
    }

    /**
     * Create an error response
     *
     * @template E
     * @param string|null $message Custom error message
     * @param int $statusCode HTTP status code
     * @param E|null $data Error details
     * @return JsonResponse<array{
     *   success: false,
     *   message: string,
     *   errors: E|null,
     *   status_code: int,
     *   timestamp: string
     * }>
     */
    public static function error(
        string $message = null,
        int $statusCode = HttpStatusConstants::HTTP_400_BAD_REQUEST,
        mixed $data = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message ?? CoreMessageConstants::get(CoreMessageConstants::GENERIC_ERROR),
            'errors' => $data,
            'status_code' => $statusCode,
            'timestamp' => now()->toIso8601String(),
        ], $statusCode);
    }
}
