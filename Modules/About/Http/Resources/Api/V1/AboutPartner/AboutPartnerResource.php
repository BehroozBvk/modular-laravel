<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutPartner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Models\AboutPartner;

/**
 * @mixin AboutPartner
 */
class AboutPartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AboutPartner $this */
        return [
            'id' => $this->id,
            'icon_path' => $this->icon_path,
            'link' => $this->link,
            'order' => $this->order,
            'name' => $this->getTranslation('name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
