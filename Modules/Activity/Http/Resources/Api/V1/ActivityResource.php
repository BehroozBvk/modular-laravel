<?php

declare(strict_types=1);

namespace Modules\Activity\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Activity\Models\Activity;

/**
 * Activity resource
 *
 * @mixin Activity
 */
class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Activity $activity */
        $activity = $this->resource;

        // Get the current translation based on the application locale
        $translation = $activity->translate(app()->getLocale());

        return [
            'id' => $activity->id,
            'slug' => $activity->slug,
            'main_image' => $activity->main_image_path,
            'cover_image' => $activity->cover_image_path,
            'video' => $activity->video_path,
            'activity_time' => $activity->activity_time?->toDateTimeString(),
            'alt_image' => $activity->alt_image_path,
            'points' => $activity->points,
            'title' => $translation->title,
            'short_description' => $translation->short_description,
            'category' => $translation->category,
            'description' => $translation->description,
            'activity_type' => $translation->activity_type,
            'meta_title' => $translation->meta_title,
            'meta_description' => $translation->meta_description,
            'meta_tags' => $translation->meta_tags,
            'created_at' => $activity->created_at?->toDateTimeString(),
            'updated_at' => $activity->updated_at?->toDateTimeString(),
        ];
    }
}
