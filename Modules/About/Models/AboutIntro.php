<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\About\Database\Factories\AboutIntroFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * About Intro Model
 *
 * @property int $id
 * @property string $image_path
 * @property string $background_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AboutIntro extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
        'background_path',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'title',
        'description',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return AboutIntroFactory::new();
    }

    /**
     * Get the translations for the intro
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutIntroTranslation::class);
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
     * Get the background path attribute.
     */
    public function backgroundPath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value) => $value,
        );
    }
}
