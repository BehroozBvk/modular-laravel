<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * About Partner Translation Model
 *
 * @property int $id
 * @property int $about_partner_id
 * @property string $locale
 * @property string $name
 * @property string $website
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AboutPartnerTranslation extends Model
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
        'about_partner_id',
        'locale',
        'name',
        'website',
    ];

    /**
     * Get the partner that owns the translation
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(AboutPartner::class, 'about_partner_id');
    }
}
