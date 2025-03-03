<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutTeamMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'image_path',
        'order',
    ];

    /**
     * Get the translations for the team member
     */
    public function translations(): HasMany
    {
        return $this->hasMany(AboutTeamMemberTranslation::class);
    }
}
