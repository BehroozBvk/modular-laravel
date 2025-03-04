<?php

declare(strict_types=1);

namespace Modules\Competition\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Competition\Models\Competition;

/**
 * @property-read Competition $resource
 */
final class CompetitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'slug' => $this->resource->slug,
            'main_image' => $this->resource->main_image,
            'cover_image' => $this->resource->cover_image,
            'video' => $this->resource->video,
            'competition_time' => $this->resource->competition_time,
            'competition_type' => $this->resource->competition_type,
            'category_id' => $this->resource->category_id,
            'points' => $this->resource->points,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,

            // Translations
            'title' => $this->resource->title,
            'short_description' => $this->resource->short_description,
            'description' => $this->resource->description,
            'meta_title' => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_tags' => $this->resource->meta_tags,
            'alt_image' => $this->resource->alt_image,
        ];
    }
}
