<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * About Team Member Translation Model
 *
 * @property int $id
 * @property int $about_team_member_id
 * @property string $locale
 * @property string $name
 * @property string $position
 * @property string $bio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AboutTeamMemberTranslation extends Model
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
        'about_team_member_id',
        'locale',
        'name',
        'position',
        'bio',
    ];

    /**
     * Get the team member that owns the translation
     */
    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(AboutTeamMember::class, 'about_team_member_id');
    }
}
