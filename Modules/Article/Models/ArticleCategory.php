<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Article\Database\Factories\ArticleCategoryFactory;
use Illuminate\Support\Str;

/**
 * Article Category Model
 *
 * @property int $id
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read string $name Translation attribute
 * @property-read Article[] $articles
 */
class ArticleCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'name',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ArticleCategoryFactory::new();
    }

    /**
     * Get the translations for the category
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ArticleCategoryTranslation::class);
    }

    /**
     * Get the articles for this category
     *
     * @return HasMany<Article>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'article_category_id');
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
