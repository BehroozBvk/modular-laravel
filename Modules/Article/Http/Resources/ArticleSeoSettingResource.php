<?php

declare(strict_types=1);

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\ArticleSeoSetting;

/**
 * @property-read ArticleSeoSetting $resource
 */
class ArticleSeoSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ArticleSeoSetting $seoSetting */
        $seoSetting = $this->resource;

        return [
            'id' => $seoSetting->id,
            'article_id' => $seoSetting->article_id,
            'image_path' => $seoSetting->imagePath(),
            'alt_image_path' => $seoSetting->altImagePath(),
            'created_at' => $seoSetting->created_at->toIso8601String(),
            'updated_at' => $seoSetting->updated_at->toIso8601String(),
            'author' => $seoSetting->author,
            'meta_title' => $seoSetting->meta_title,
            'meta_description' => $seoSetting->meta_description,
            'meta_tags' => $seoSetting->meta_tags,
            'keywords' => $seoSetting->keywords,
        ];
    }
}
