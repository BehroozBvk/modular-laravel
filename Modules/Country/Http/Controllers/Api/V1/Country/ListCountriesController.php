<?php

declare(strict_types=1);

namespace Modules\Country\Http\Controllers\Api\V1\Country;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Country\Http\Requests\Api\V1\ListCountriesRequest;
use Modules\Country\Services\CountryService;

/**
 * List countries endpoint
 * 
 * @group Countries
 * 
 * @subgroup Country Management
 * 
 * @queryParam page int Page number. Example: 1
 * @queryParam per_page int Items per page (1-100). Example: 15
 * @queryParam sort_by string Sort by field (created_at, name). Example: name
 * @queryParam sort_direction string Sort direction (asc, desc). Example: asc
 * 
 * @apiResource Modules\Country\Http\Resources\CountryResource
 * @apiResourceCollection Modules\Country\Http\Resources\CountryCollection
 * 
 * @response 200 scenario="Success" {
 *   "success": true,
 *   "message": "Operation successful",
 *   "data": {
 *     "items": [
 *       {
 *         "id": 1,
 *         "name": "United States",
 *         "code": "US",
 *         "flag": "us.png",
 *         "created_at": "2023-01-01T00:00:00.000000Z",
 *         "updated_at": "2023-01-01T00:00:00.000000Z"
 *       }
 *     ],
 *     "meta": {
 *       "current_page": 1,
 *       "from": 1,
 *       "last_page": 10,
 *       "per_page": 15,
 *       "to": 15,
 *       "total": 150
 *     }
 *   },
 *   "status_code": 200,
 *   "timestamp": "2023-01-01T00:00:00.000000Z"
 * }
 * 
 * @response 500 scenario="Server Error" {
 *   "success": false,
 *   "message": "An error occurred while fetching countries",
 *   "errors": null,
 *   "status_code": 500,
 *   "timestamp": "2023-01-01T00:00:00.000000Z"
 * }
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
