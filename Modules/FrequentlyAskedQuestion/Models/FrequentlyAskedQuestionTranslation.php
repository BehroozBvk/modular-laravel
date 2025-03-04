<?php

namespace Modules\FrequentlyAskedQuestion\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\FrequentlyAskedQuestion\Database\Factories\FrequentlyAskedQuestionTranslationFactory;

class FrequentlyAskedQuestionTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): FrequentlyAskedQuestionTranslationFactory
    // {
    //     // return FrequentlyAskedQuestionTranslationFactory::new();
    // }
}
