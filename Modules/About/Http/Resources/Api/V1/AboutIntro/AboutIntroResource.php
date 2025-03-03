<?php

declare(strict_types=1);

namespace Modules\About\Http\Resources\Api\V1\AboutIntro;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\About\Models\AboutIntro;

/**
 * @mixin AboutIntro
 */
class AboutIntroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AboutIntro $this */
        return [
            'id' => $this->id,
            'image_path' => $this->image_path,
            'background_path' => $this->background_path,
            'title' => $this->getTranslation('title'),
            'description' => $this->getTranslation('description'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
