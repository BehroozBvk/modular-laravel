<?php

declare(strict_types=1);

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Article\Models\ArticleComment;

/**
 * @property-read ArticleComment $resource
 */
class ArticleCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ArticleComment $comment */
        $comment = $this->resource;

        return [
            'id' => $comment->id,
            'article_id' => $comment->article_id,
            'user_id' => $comment->user_id,
            'comment' => $comment->comment,
            'parent_id' => $comment->parent_id,
            'created_at' => $comment->created_at->toIso8601String(),
            'updated_at' => $comment->updated_at->toIso8601String(),
            'replies' => $comment->replies
                ? ArticleCommentResource::collection($comment->replies)
                : [],
        ];
    }
}
