<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Http\Resources\Api\V1\AboutIntro\AboutIntroResource;
use Modules\About\Http\Resources\Api\V1\AboutPartner\AboutPartnerResource;
use Modules\About\Http\Resources\Api\V1\AboutSection\AboutSectionResource;
use Modules\About\Http\Resources\Api\V1\AboutTeam\AboutTeamMemberResource;
use Modules\About\Http\Resources\Api\V1\AboutTeam\AboutTeamSettingResource;

/**
 * Resource for About page data
 *
 * @property array $resource
 */
final class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request The incoming HTTP request
     * @return array<string, mixed> The transformed resource
     */
    public function toArray(Request $request): array
    {
        /** @var AboutIntroResource|null $intro */
        $intro = $this->resource['intro']
            ? new AboutIntroResource($this->resource['intro'])
            : null;

        /** @var AboutSectionResource[] $sections */
        $sections = AboutSectionResource::collection($this->resource['sections']);

        /** @var AboutTeamSettingResource|null $teamSettings */
        $teamSettings = $this->resource['team_settings']
            ? new AboutTeamSettingResource($this->resource['team_settings'])
            : null;

        /** @var AboutTeamMemberResource[] $teamMembers */
        $teamMembers = AboutTeamMemberResource::collection($this->resource['team_members']);

        /** @var AboutPartnerResource[] $partners */
        $partners = AboutPartnerResource::collection($this->resource['partners']);

        return [
            'intro' => $intro,
            'sections' => $sections,
            'team' => [
                'settings' => $teamSettings,
                'members' => $teamMembers,
            ],
            'partners' => $partners,
        ];
    }
}
