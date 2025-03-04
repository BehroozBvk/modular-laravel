<?php

namespace Modules\AppSetting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AppSetting\Database\Factories\MenuLinkTranslationFactory;

class MenuLinkTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MenuLinkTranslationFactory
    // {
    //     // return MenuLinkTranslationFactory::new();
    // }
}
