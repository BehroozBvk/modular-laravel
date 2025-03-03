<?php

declare(strict_types=1);

namespace Modules\About\Http\Controllers\Api\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\About\Services\AboutService;
use Modules\About\Http\Resources\Api\V1\AboutResource;

/**
 * @OA\Get(
 *     path="/api/v1/about",
 *     summary="Get about page data",
 *     description="Returns all data needed for the about page including intro, sections, team members and partners",
 *     operationId="getAboutData",
 *     tags={"About"},
 *     security={{"passport": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="About page data retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="About page data retrieved successfully"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="intro", type="object"),
 *                 @OA\Property(property="sections", type="array", @OA\Items(type="object")),
 *                 @OA\Property(
 *                     property="team",
 *                     type="object",
 *                     @OA\Property(property="visible", type="boolean"),
 *                     @OA\Property(property="members", type="array", @OA\Items(type="object"))
 *                 ),
 *                 @OA\Property(property="partners", type="array", @OA\Items(type="object"))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class GetAboutDataController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AboutService $aboutService
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $aboutData = $this->aboutService->getAboutPageData();

            return $this->successResponse(
                data: new AboutResource($aboutData),
                message: 'About page data retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
