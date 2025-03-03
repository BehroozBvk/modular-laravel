<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutTeam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Models\AboutTeamMember;

/**
 * @mixin AboutTeamMember
 */
class AboutTeamMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AboutTeamMember $this */
        return [
            'id' => $this->id,
            'image_path' => $this->image_path,
            'order' => $this->order,
            'name' => $this->getTranslation('name'),
            'position' => $this->getTranslation('position'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
