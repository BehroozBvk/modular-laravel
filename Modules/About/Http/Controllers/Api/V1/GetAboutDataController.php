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
 * Controller for retrieving about page data
 *
 * @group About
 * @subgroup About Page
 */
class GetAboutDataController extends BaseApiV1Controller
{
    public function __construct(
        private readonly AboutService $aboutService
    ) {}

    /**
     * Get about page data
     *
     * Returns all data needed for the about page including intro, sections, team members, and partners.
     *
     * @response status=200 scenario="Success" {
     *     "status": "success",
     *     "message": "About page data retrieved successfully",
     *     "data": {
     *         "intro": {
     *             "id": 1,
     *             "image_path": "images/about/intro.jpg",
     *             "background_path": "images/about/background.jpg",
     *             "title": "About Us",
     *             "description": "We are a company dedicated to excellence"
     *         },
     *         "sections": [
     *             {
     *                 "id": 1,
     *                 "image_path": "images/about/section1.jpg",
     *                 "order": 1,
     *                 "title": "Our Mission",
     *                 "content": "To provide the best service possible"
     *             }
     *         ],
     *         "team": {
     *             "visible": true,
     *             "members": [
     *                 {
     *                     "id": 1,
     *                     "image_path": "images/team/member1.jpg",
     *                     "order": 1,
     *                     "name": "John Doe",
     *                     "position": "CEO",
     *                     "bio": "Experienced leader with 10+ years in the industry"
     *                 }
     *             ]
     *         },
     *         "partners": [
     *             {
     *                 "id": 1,
     *                 "image_path": "images/partners/partner1.jpg",
     *                 "order": 1,
     *                 "name": "Partner Company",
     *                 "website": "https://partner.com"
     *             }
     *         ]
     *     }
     * }
     *
     * @response status=500 scenario="Server Error" {
     *     "status": "error",
     *     "message": "An error occurred while retrieving about page data",
     *     "data": null
     * }
     *
     * @return JsonResponse
     */
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
                message: 'An error occurred while retrieving about page data',
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
