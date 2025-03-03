<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTeamSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'visible',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'visible' => 'boolean',
    ];
}
