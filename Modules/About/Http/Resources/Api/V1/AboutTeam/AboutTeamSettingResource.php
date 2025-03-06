<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutTeam;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Models\AboutTeamSetting;

/**
 * @mixin AboutTeamSetting
 */
class AboutTeamSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AboutTeamSetting $this */
        return [
            'id' => $this->id,
            'visible' => $this->visible,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
