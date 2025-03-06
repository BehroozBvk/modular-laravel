<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\About\Database\Factories\AboutPartnerFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * Class AboutPartner
 *
 * Represents a partner in the About module.
 *
 * @property int $id The unique identifier for the partner.
 * @property string $icon_path The path to the partner's icon.
 * @property string $link The link associated with the partner.
 * @property int $order The display order of the partner.
 * @property \Carbon\Carbon $created_at The date and time when the partner was created.
 * @property \Carbon\Carbon $updated_at The date and time when the partner was last updated.
 *
 * @method static AboutPartnerFactory factory(...$parameters) Create a new factory instance for the model.
 */
class AboutPartner extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon_path',
        'link',
        'order',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public array $translatedAttributes = [
        'name',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return AboutPartnerFactory
     */
    protected static function newFactory(): AboutPartnerFactory
    {
        return AboutPartnerFactory::new();
    }

    /**
     * Get the translations for the partner.
     *
     * @return HasMany<AboutPartnerTranslation>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutPartnerTranslation::class);
    }

    /**
     * Get the icon path attribute.
     */
    public function iconPath(): Attribute
    {
        return Attribute::make(
            get: fn($value): string|UrlGenerator|null => $value ? url("storage/{$value}") : null,
            set: fn($value) => $value,
        );
    }
}
