<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\About\Database\Factories\AboutSectionFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * About Section Model
 *
 * @property int $id
 * @property string $icon_path
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AboutSection extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon_path',
        'order',
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
    protected static function newFactory(): AboutSectionFactory
    {
        return AboutSectionFactory::new();
    }

    /**
     * Get the translations for the section
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutSectionTranslation::class);
    }

    /**
     * Get the image path attribute.
     */
    public function iconPath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn(?string $value): ?string => $value,
        );
    }
}
