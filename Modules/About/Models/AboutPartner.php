<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutPartner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'icon_path',
        'link',
        'order',
    ];

    /**
     * Get the translations for the partner
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutPartnerTranslation::class);
    }
}
