<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutTeam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'visible' => $this['visible'],
            'members' => AboutTeamMemberResource::collection($this['members']),
        ];
    }
}
