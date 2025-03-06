<?php

declare(strict_types=1);

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\Article\Database\Factories\ArticleSeoSettingTranslationFactory;

/**
 * Article SEO Setting Translation Model
 *
 * @property int $id
 * @property int $article_seo_setting_id
 * @property string $locale
 * @property string|null $author
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_tags
 * @property string|null $keywords
 */
class ArticleSeoSettingTranslation extends Model
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
        'article_seo_setting_id',
        'locale',
        'author',
        'meta_title',
        'meta_description',
        'meta_tags',
        'keywords',
    ];

    /**
     * Get the SEO setting that owns the translation
     *
     * @return BelongsTo<ArticleSeoSetting, ArticleSeoSettingTranslation>
     */
    public function seoSetting(): BelongsTo
    {
        return $this->belongsTo(ArticleSeoSetting::class, 'article_seo_setting_id');
    }

    // protected static function newFactory(): ArticleSeoSettingTranslationFactory
    // {
    //     // return ArticleSeoSettingTranslationFactory::new();
    // }
}
