<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutPartnerTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_partner_id',
        'locale',
        'name',
    ];

    /**
     * Get the partner that owns the translation
     */
    public function aboutPartner(): BelongsTo
    {
        return $this->belongsTo(AboutPartner::class);
    }
}
