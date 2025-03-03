<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutTeamMemberTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_team_member_id',
        'locale',
        'name',
        'position',
    ];

    /**
     * Get the team member that owns the translation
     */
    public function aboutTeamMember(): BelongsTo
    {
        return $this->belongsTo(AboutTeamMember::class);
    }
}
