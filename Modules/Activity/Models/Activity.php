<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Routing\UrlGenerator;
use Modules\Activity\Database\Factories\ActivityFactory;

/**
 * Activity Model
 *
 * @property int $id
 * @property string $slug
 * @property string $main_image_path
 * @property string $cover_image_path
 * @property string|null $video_path
 * @property \Carbon\Carbon|null $activity_time
 * @property string $alt_image_path
 * @property int $points
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read string $title Translation attribute
 * @property-read string $short_description Translation attribute
 * @property-read string $category Translation attribute
 * @property-read string $description Translation attribute
 * @property-read string $activity_type Translation attribute
 * @property-read string $meta_title Translation attribute
 * @property-read string $meta_description Translation attribute
 * @property-read string $meta_tags Translation attribute
 */
class Activity extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'main_image_path',
        'cover_image_path',
        'video_path',
        'activity_time',
        'alt_image_path',
        'points',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'title',
        'short_description',
        'category',
        'description',
        'activity_type',
        'meta_title',
        'meta_description',
        'meta_tags',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'activity_time' => 'datetime',
            'points' => 'integer',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ActivityFactory::new();
    }

    /**
     * Get the translations for the activity
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ActivityTranslation::class);
    }

    /**
     * Get the main image path attribute.
     */
    public function mainImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value): string => $value,
        );
    }

    /**
     * Get the cover image path attribute.
     */
    public function coverImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value): string => $value,
        );
    }

    /**
     * Get the video path attribute.
     */
    public function videoPath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value): string => $value,
        );
    }

    /**
     * Get the alt image path attribute.
     */
    public function altImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value): string => $value,
        );
    }
}
