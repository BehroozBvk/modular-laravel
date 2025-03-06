<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\Article\Database\Factories\ArticleTranslationFactory;

/**
 * Article Translation Model
 *
 * @property int $id
 * @property int $article_id
 * @property string $locale
 * @property string $title
 * @property string $description
 */
class ArticleTranslation extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'locale',
        'title',
        'description',
    ];

    /**
     * Get the article that owns the translation
     *
     * @return BelongsTo<Article, ArticleTranslation>
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    // protected static function newFactory(): ArticleTranslationFactory
    // {
    //     // return ArticleTranslationFactory::new();
    // }
}
