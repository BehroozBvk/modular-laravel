<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Admin\ResendVerificationEmailAdminRequest;
use Modules\Auth\Services\Admin\AdminAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/admin/resend-verification-email",
 *     tags={"Admin Auth"},
 *     summary="Resend verification email to admin",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/ResendVerificationEmailAdminRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Verification email sent successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Email already verified",
 *
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
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
final class ResendVerificationEmailAdminController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function __invoke(ResendVerificationEmailAdminRequest $request)
    {
        try {
            $this->adminAuthService->resendVerificationEmail($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_VERIFICATION_EMAIL_SENT)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_400_BAD_REQUEST
            );
        }
    }
}
