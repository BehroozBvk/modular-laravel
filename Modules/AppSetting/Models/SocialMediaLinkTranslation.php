<?php

namespace Modules\AppSetting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AppSetting\Database\Factories\SocialMediaLinkTranslationFactory;

class SocialMediaLinkTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): SocialMediaLinkTranslationFactory
    // {
    //     // return SocialMediaLinkTranslationFactory::new();
    // }
}
