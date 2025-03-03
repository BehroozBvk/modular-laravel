<?php

declare(strict_types=1);

namespace Modules\About\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\About\Database\Factories\AboutTeamMemberFactory;

class AboutTeamMember extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'image_path',
        'order',
    ];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = [
        'name',
        'position',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return AboutTeamMemberFactory::new();
    }
}
