<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\About\Database\Factories\AboutIntroFactory;

class AboutIntro extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
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
}
