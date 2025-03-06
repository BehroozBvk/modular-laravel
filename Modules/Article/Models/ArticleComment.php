<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Article\Database\Factories\ArticleCommentFactory;
use App\Models\User;

/**
 * Article Comment Model
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string $comment
 * @property int|null $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read Article $article
 * @property-read User $user
 * @property-read ArticleComment|null $parent
 * @property-read ArticleComment[] $replies
 */
class ArticleComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'comment',
        'parent_id',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ArticleCommentFactory::new();
    }

    /**
     * Get the article that owns the comment
     *
     * @return BelongsTo<Article, ArticleComment>
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the user that owns the comment
     *
     * @return BelongsTo<User, ArticleComment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment
     *
     * @return BelongsTo<ArticleComment, ArticleComment>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ArticleComment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment
     *
     * @return HasMany<ArticleComment>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'parent_id');
    }
}
