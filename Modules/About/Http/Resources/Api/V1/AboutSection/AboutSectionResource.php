<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutSection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Models\AboutSection;

/**
 * @mixin AboutSection
 */
class AboutSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AboutSection $this */
        return [
            'id' => $this->id,
            'icon_path' => $this->icon_path,
            'order' => $this->order,
            'title' => $this->getTranslation('title'),
            'description' => $this->getTranslation('description'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
