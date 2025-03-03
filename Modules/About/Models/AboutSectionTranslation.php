<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutSectionTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_section_id',
        'locale',
        'title',
        'description',
    ];

    /**
     * Get the section that owns the translation
     */
    public function aboutSection(): BelongsTo
    {
        return $this->belongsTo(AboutSection::class);
    }
}
