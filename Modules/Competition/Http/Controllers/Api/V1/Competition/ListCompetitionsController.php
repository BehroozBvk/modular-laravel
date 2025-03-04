<?php

declare(strict_types=1);

namespace Modules\Competition\Http\Controllers\Api\V1\Competition;

use Modules\Competition\Services\CompetitionService;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Competition\Http\Resources\Api\V1\CompetitionResource;

/**
 * @group Competitions
 *
 * APIs for managing competitions
 */
final class ListCompetitionsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly CompetitionService $competitionService,
    ) {}

    /**
     * List Competitions
     *
     * Get a paginated list of competitions.
     *
     * @queryParam page integer Page number for pagination. Example: 1
     * @queryParam per_page integer Number of items per page. Example: 15
     *
     * @response 200 {
     *     "data": [
     *         {
     *             "id": 1,
     *             "slug": "summer-competition-2024",
     *             "main_image": "competitions/summer-2024.jpg",
     *             "cover_image": "competitions/summer-2024-cover.jpg",
     *             "video": "competitions/summer-2024.mp4",
     *             "competition_time": "2024-06-01T00:00:00.000000Z",
     *             "competition_type": "seasonal",
     *             "category_id": 1,
     *             "points": 100,
     *             "created_at": "2024-03-04T20:55:57.000000Z",
     *             "updated_at": "2024-03-04T20:55:57.000000Z",
     *             "title": "Summer Competition 2024",
     *             "short_description": "Join our exciting summer competition!",
     *             "description": "Detailed description of the competition...",
     *             "meta_title": "Summer Competition 2024 | Your Platform",
     *             "meta_description": "Join our exciting summer competition and win amazing prizes!",
     *             "meta_tags": "competition, summer, 2024, prizes",
     *             "alt_image": "Summer Competition 2024 Banner"
     *         }
     *     ],
     *     "links": {
     *         "first": "http://example.com/api/v1/competitions?page=1",
     *         "last": "http://example.com/api/v1/competitions?page=1",
     *         "prev": null,
     *         "next": null
     *     },
     *     "meta": {
     *         "current_page": 1,
     *         "from": 1,
     *         "last_page": 1,
     *         "links": [],
     *         "path": "http://example.com/api/v1/competitions",
     *         "per_page": 15,
     *         "to": 1,
     *         "total": 1
     *     }
     * }
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $competitions = $this->competitionService->getPaginatedCompetitions();

        return CompetitionResource::collection($competitions);
    }
}
