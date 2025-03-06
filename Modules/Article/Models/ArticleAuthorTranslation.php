<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\Article\Database\Factories\ArticleAuthorTranslationFactory;

/**
 * Article Author Translation Model
 *
 * @property int $id
 * @property int $article_author_id
 * @property string $locale
 * @property string $name
 * @property string|null $bio
 */
class ArticleAuthorTranslation extends Model
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
        'article_author_id',
        'locale',
        'name',
        'bio',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bio' => 'string',
    ];

    /**
     * Get the author that owns the translation
     *
     * @return BelongsTo<ArticleAuthor, ArticleAuthorTranslation>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(ArticleAuthor::class, 'article_author_id');
    }

    // protected static function newFactory(): ArticleAuthorTranslationFactory
    // {
    //     // return ArticleAuthorTranslationFactory::new();
    // }
}
