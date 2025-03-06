<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;
use Modules\Article\Database\Factories\ArticleSeoSettingFactory;

/**
 * Article SEO Setting Model
 *
 * @property int $id
 * @property int $article_id
 * @property string|null $image_path
 * @property string|null $alt_image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read string|null $author Translation attribute
 * @property-read string|null $meta_title Translation attribute
 * @property-read string|null $meta_description Translation attribute
 * @property-read string|null $meta_tags Translation attribute
 * @property-read string|null $keywords Translation attribute
 * 
 * @property-read Article $article
 */
class ArticleSeoSetting extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'article_id',
        'image_path',
        'alt_image_path',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'author',
        'meta_title',
        'meta_description',
        'meta_tags',
        'keywords',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ArticleSeoSettingFactory::new();
    }

    /**
     * Get the translations for the SEO settings
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ArticleSeoSettingTranslation::class);
    }

    /**
     * Get the article that owns the SEO settings
     *
     * @return BelongsTo<Article, ArticleSeoSetting>
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the image path attribute.
     */
    public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value) => $value,
        );
    }

    /**
     * Get the alt image path attribute.
     */
    public function altImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value) => $value,
        );
    }
}
