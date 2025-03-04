<?php

namespace Modules\Competition\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Competition\Database\Factories\CompetitionContentTranslationFactory;

class CompetitionContentTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): CompetitionContentTranslationFactory
    // {
    //     // return CompetitionContentTranslationFactory::new();
    // }
}
