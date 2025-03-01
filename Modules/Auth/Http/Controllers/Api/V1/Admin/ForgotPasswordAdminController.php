<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Admin\ForgotPasswordAdminRequest;
use Modules\Auth\Services\Admin\AdminAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/admin/forgot-password",
 *     tags={"Admin Auth"},
 *     summary="Send password reset link to admin's email",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/ForgotPasswordAdminRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Password reset link sent successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Admin not found",
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
final class ForgotPasswordAdminController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function __invoke(ForgotPasswordAdminRequest $request)
    {
        try {
            $this->adminAuthService->sendPasswordResetLink($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_PASSWORD_RESET_LINK_SENT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_404_NOT_FOUND
            );
        }
    }
}
