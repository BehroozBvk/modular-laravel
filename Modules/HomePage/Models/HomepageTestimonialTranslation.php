<?php

namespace Modules\HomePage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HomePage\Database\Factories\HomepageTestimonialTranslationFactory;

class HomepageTestimonialTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): HomepageTestimonialTranslationFactory
    // {
    //     // return HomepageTestimonialTranslationFactory::new();
    // }
}
