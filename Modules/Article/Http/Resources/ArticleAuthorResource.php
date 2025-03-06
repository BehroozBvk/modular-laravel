<?php

declare(strict_types=1);

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\ArticleAuthor;

/**
 * @property-read ArticleAuthor $resource
 */
class ArticleAuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ArticleAuthor $author */
        $author = $this->resource;

        return [
            'id' => $author->id,
            'image_path' => $author->imagePath(),
            'created_at' => $author->created_at->toIso8601String(),
            'updated_at' => $author->updated_at->toIso8601String(),
            'name' => $author->name,
            'bio' => $author->bio,
        ];
    }
}
