<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutIntroTranslation extends Model
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
     */
    protected $fillable = [
        'about_intro_id',
        'locale',
        'title',
        'description',
    ];

    /**
     * Get the intro that owns the translation
     */
    public function aboutIntro(): BelongsTo
    {
        return $this->belongsTo(AboutIntro::class);
    }
}
