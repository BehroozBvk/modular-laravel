<?php

namespace Modules\AppSetting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AppSetting\Database\Factories\SocialMediaLinkFactory;

class SocialMediaLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): SocialMediaLinkFactory
    // {
    //     // return SocialMediaLinkFactory::new();
    // }
}
