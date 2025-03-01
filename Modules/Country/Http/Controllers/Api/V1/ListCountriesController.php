<?php

declare(strict_types=1);

namespace Modules\Country\Http\Controllers\Api\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Country\Http\Requests\Api\V1\ListCountriesRequest;
use Modules\Country\Services\CountryService;

/**
 * @OA\Get(
 *     path="/countries",
 *     tags={"Countries"},
 *     summary="List all countries",
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number",
 *         required=false,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Items per page (1-100)",
 *         required=false,
 *
 *         @OA\Schema(type="integer", minimum=1, maximum=100)
 *     ),
 *
 *     @OA\Parameter(
 *         name="sort_by",
 *         in="query",
 *         description="Sort by field (created_at, name)",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"created_at", "name"})
 *     ),
 *
 *     @OA\Parameter(
 *         name="sort_direction",
 *         in="query",
 *         description="Sort direction",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"asc", "desc"})
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="List of countries",
 *
 *         @OA\JsonContent(
 *             type="object",
 *             
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="name", type="string"),
 *                 )
 *             ),
 *             
 *             @OA\Property(property="meta", type="object",
 *                 @OA\Property(property="current_page", type="integer"),
 *                 @OA\Property(property="from", type="integer"),
 *                 @OA\Property(property="last_page", type="integer"),
 *                 @OA\Property(property="per_page", type="integer"),
 *                 @OA\Property(property="to", type="integer"),
 *                 @OA\Property(property="total", type="integer")
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
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
final class ListCountriesController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CountryService $countryService
    ) {}

    public function __invoke(ListCountriesRequest $request): JsonResponse
    {
        try {
            $countries = $this->countryService->getCountries($request->toDto());

            return $this->paginatedResponse($countries);
        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
