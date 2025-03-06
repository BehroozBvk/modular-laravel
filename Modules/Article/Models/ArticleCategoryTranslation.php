<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\Article\Database\Factories\ArticleCategoryTranslationFactory;

/**
 * Article Category Translation Model
 *
 * @property int $id
 * @property int $article_category_id
 * @property string $locale
 * @property string $name
 */
class ArticleCategoryTranslation extends Model
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
        'article_category_id',
        'locale',
        'name',
    ];

    /**
     * Get the category that owns the translation
     *
     * @return BelongsTo<ArticleCategory, ArticleCategoryTranslation>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    // protected static function newFactory(): ArticleCategoryTranslationFactory
    // {
    //     // return ArticleCategoryTranslationFactory::new();
    // }
}
