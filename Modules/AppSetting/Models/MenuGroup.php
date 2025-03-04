<?php

namespace Modules\AppSetting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AppSetting\Database\Factories\MenuGroupFactory;

class MenuGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MenuGroupFactory
    // {
    //     // return MenuGroupFactory::new();
    // }
}
