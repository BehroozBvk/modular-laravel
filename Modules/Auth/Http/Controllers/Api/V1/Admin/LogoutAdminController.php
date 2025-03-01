<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/admin/logout",
 *     tags={"Admin Auth"},
 *     summary="Logout a admin",
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Admin logged out successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated",
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
final class LogoutAdminController extends BaseApiV1Controller
{
    public function __invoke()
    {
        try {
            request()->user()->token()->revoke();

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_LOGGED_OUT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
