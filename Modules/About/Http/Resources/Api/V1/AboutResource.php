<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Http\Resources\Api\V1\AboutIntro\AboutIntroResource;
use Modules\About\Http\Resources\Api\V1\AboutPartner\AboutPartnerResource;
use Modules\About\Http\Resources\Api\V1\AboutSection\AboutSectionResource;
use Modules\About\Http\Resources\Api\V1\AboutTeam\AboutTeamResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'intro' => $this['intro'] ? new AboutIntroResource($this['intro']) : null,
            'sections' => AboutSectionResource::collection($this['sections']),
            'team' => new AboutTeamResource($this['team']),
            'partners' => AboutPartnerResource::collection($this['partners']),
        ];
    }
}
