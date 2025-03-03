<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\About\Database\Factories\AboutPartnerFactory;

class AboutPartner extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'icon_path',
        'link',
        'order',
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
        return AboutPartnerFactory::new();
    }

    /**
     * Get the translations for the partner
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutPartnerTranslation::class);
    }
}
