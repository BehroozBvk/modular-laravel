<?php

declare(strict_types=1);

namespace Modules\Competition\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Competition\Database\Factories\CompetitionFactory;

class Competition extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected array $fillable = [
        'slug',
        'main_image',
        'cover_image',
        'video',
        'competition_time',
        'competition_type',
        'category_id',
        'points'
    ];

    /**
     * Translatable attributes.
     *
     * @var array<int, string>
     */
    public array $translatedAttributes = [
        'title',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_tags',
        'alt_image'
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'competition_time' => 'datetime',
            'points' => 'integer',
            'category_id' => 'integer'
        ];
    }

    /**
     * Get the competition FAQs
     *
     * @return HasMany<CompetitionFaq>
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(CompetitionFaq::class);
    }

    /**
     * Get the competition content items
     *
     * @return HasMany<CompetitionContent>
     */
    public function contents(): HasMany
    {
        return $this->hasMany(CompetitionContent::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CompetitionFactory
    {
        return CompetitionFactory::new();
    }
}
