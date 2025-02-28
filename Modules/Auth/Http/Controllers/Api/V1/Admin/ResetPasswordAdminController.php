<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\Admin\ResetPasswordAdminRequest,
    Services\Admin\AdminAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/admin/reset-password",
 *     tags={"Admin Auth"},
 *     summary="Reset admin's password",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ResetPasswordAdminRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid token",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Admin not found",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class ResetPasswordAdminController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function __invoke(ResetPasswordAdminRequest $request)
    {
        try {
            $this->adminAuthService->resetPassword($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_PASSWORD_RESET_SUCCESS)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
