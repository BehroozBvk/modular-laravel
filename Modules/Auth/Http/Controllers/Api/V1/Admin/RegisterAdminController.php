<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Auth\{
    Http\Requests\Api\V1\Admin\RegisterAdminRequest,
    Http\Resources\Api\V1\Admin\RegisterAdminResource,
    Services\Admin\AdminAuthService,
    Constants\Messages\AuthMessageConstants
};

/**
 * @OA\Post(
 *     path="/auth/admin/register",
 *     tags={"Admin Auth"},
 *     summary="Register a new admin",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/RegisterAdminRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Admin registered successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
final class RegisterAdminController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function __invoke(RegisterAdminRequest $request)
    {
        try {
            $admin = $this->adminAuthService->register($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_REGISTERED),
                statusCode: HttpStatusConstants::HTTP_201_CREATED,
                data: new RegisterAdminResource($admin)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_REGISTRATION_FAILED),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
