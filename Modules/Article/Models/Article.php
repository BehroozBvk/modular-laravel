<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Article\Database\Factories\ArticleFactory;
use Illuminate\Support\Str;

/**
 * Article Model
 *
 * @property int $id
 * @property string $slug
 * @property int $article_category_id
 * @property int $article_author_id
 * @property int $views
 * @property int $likes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read string $title Translation attribute
 * @property-read string $description Translation attribute
 * 
 * @property-read ArticleCategory $category
 * @property-read ArticleAuthor $author
 * @property-read ArticleSeoSetting $seoSettings
 * @property-read ArticleComment[] $comments
 */
class Article extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'article_category_id',
        'article_author_id',
        'views',
        'likes',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'views' => 'integer',
            'likes' => 'integer',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ArticleFactory::new();
    }

    /**
     * Get the translations for the article
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ArticleTranslation::class);
    }

    /**
     * Get the category relationship
     *
     * @return BelongsTo<ArticleCategory, Article>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    /**
     * Get the author relationship
     *
     * @return BelongsTo<ArticleAuthor, Article>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(ArticleAuthor::class, 'article_author_id');
    }

    /**
     * Get the SEO settings relationship
     *
     * @return HasOne<ArticleSeoSetting>
     */
    public function seoSettings(): HasOne
    {
        return $this->hasOne(ArticleSeoSetting::class);
    }

    /**
     * Get the comments relationship
     *
     * @return HasMany<ArticleComment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    /**
     * Set the slug attribute
     *
     * @param string $value
     */
    public function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
