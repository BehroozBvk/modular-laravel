<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;
use Modules\Article\Database\Factories\ArticleAuthorFactory;

/**
 * Article Author Model
 *
 * @property int $id
 * @property string $image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read string $name Translation attribute
 * @property-read string|null $bio Translation attribute
 * @property-read Article[] $articles
 */
class ArticleAuthor extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'name',
        'bio',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ArticleAuthorFactory::new();
    }

    /**
     * Get the translations for the author
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ArticleAuthorTranslation::class);
    }

    /**
     * Get the articles for this author
     *
     * @return HasMany<Article>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'article_author_id');
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
}
