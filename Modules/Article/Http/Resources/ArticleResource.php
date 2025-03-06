<?php

declare(strict_types=1);

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\Article;

/**
 * @property-read Article $resource
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Article $article */
        $article = $this->resource;

        return [
            'id' => $article->id,
            'slug' => $article->slug,
            'image_path' => $article->imagePath(),
            'created_at' => $article->created_at->toIso8601String(),
            'updated_at' => $article->updated_at->toIso8601String(),
            'title' => $article->title,
            'description' => $article->description,
            'content' => $article->content,
            'category' => $article->category
                ? new ArticleCategoryResource($article->category)
                : null,
            'author' => $article->author
                ? new ArticleAuthorResource($article->author)
                : null,
            'seo_settings' => $article->seoSetting
                ? new ArticleSeoSettingResource($article->seoSetting)
                : null,
            'comments' => ArticleCommentResource::collection(
                $article->comments->whereNull('parent_id')
            ),
        ];
    }
}
