<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * About Intro Translation Model
 *
 * @property int $id
 * @property int $about_intro_id
 * @property string $locale
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
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
     *
     * @var array<int, string>
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
    public function intro(): BelongsTo
    {
        return $this->belongsTo(AboutIntro::class, 'about_intro_id');
    }
}
