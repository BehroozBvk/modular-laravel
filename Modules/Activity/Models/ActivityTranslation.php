<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Modules\Activity\Database\Factories\ActivityTranslationFactory;

/**
 * Activity Translation Model
 *
 * @property int $id
 * @property int $activity_id
 * @property string $locale
 * @property string $title
 * @property string $short_description
 * @property string $category
 * @property string $description
 * @property string $activity_type
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_tags
 */
class ActivityTranslation extends Model
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
        'activity_id',
        'locale',
        'title',
        'short_description',
        'category',
        'description',
        'activity_type',
        'meta_title',
        'meta_description',
        'meta_tags',
    ];

    /**
     * Get the activity that owns the translation
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    // protected static function newFactory(): ActivityTranslationFactory
    // {
    //     // return ActivityTranslationFactory::new();
    // }
}
