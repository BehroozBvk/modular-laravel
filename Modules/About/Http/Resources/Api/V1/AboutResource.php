<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Http\Resources\Api\V1\AboutIntro\AboutIntroResource;
use Modules\About\Http\Resources\Api\V1\AboutPartner\AboutPartnerResource;
use Modules\About\Http\Resources\Api\V1\AboutSection\AboutSectionResource;
use Modules\About\Http\Resources\Api\V1\AboutTeam\AboutTeamResource;

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
        return [
            'intro' => $this->resource['intro'],
            'sections' => $this->resource['sections'],
            'team' => $this->resource['team'],
            'partners' => $this->resource['partners'],
        ];
    }
}
