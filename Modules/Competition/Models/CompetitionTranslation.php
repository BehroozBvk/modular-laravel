<?php

namespace Modules\Competition\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Competition\Database\Factories\CompetitionTranslationFactory;

class CompetitionTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): CompetitionTranslationFactory
    // {
    //     // return CompetitionTranslationFactory::new();
    // }
}
