<?php

declare(strict_types=1);

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\ArticleCategory;

/**
 * @property-read ArticleCategory $resource
 */
class ArticleCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ArticleCategory $category */
        $category = $this->resource;

        return [
            'id' => $category->id,
            'slug' => $category->slug,
            'created_at' => $category->created_at->toIso8601String(),
            'updated_at' => $category->updated_at->toIso8601String(),
            'name' => $category->name,
        ];
    }
}
