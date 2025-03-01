<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api\V1\Admin;

use Exception;
use Modules\Auth\Constants\Messages\AuthMessageConstants;
use Modules\Auth\Http\Requests\Api\V1\Admin\LoginAdminRequest;
use Modules\Auth\Http\Resources\Api\V1\Admin\LoginAdminResource;
use Modules\Auth\Services\Admin\AdminAuthService;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;

/**
 * @OA\Post(
 *     path="/auth/admin/login",
 *     tags={"Admin Auth"},
 *     summary="Login a admin",
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(ref="#/components/schemas/LoginAdminRequest")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Admin logged in successfully",
 *
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
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
final class LoginAdminController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function __invoke(LoginAdminRequest $request)
    {
        try {
            $token = $this->adminAuthService->login($request->toDto());

            return $this->successResponse(
                message: AuthMessageConstants::get(AuthMessageConstants::ADMIN_LOGGED_IN),
                data: new LoginAdminResource($token)
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_401_UNAUTHORIZED
            );
        }
    }
}
