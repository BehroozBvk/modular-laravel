<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutIntro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'image_path',
        'background_path',
    ];

    /**
     * Get the translations for the intro
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutIntroTranslation::class);
    }
}
