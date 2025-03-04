<?php

namespace Modules\HomePage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HomePage\Database\Factories\HomepageAppButtonFactory;

class HomepageAppButton extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): HomepageAppButtonFactory
    // {
    //     // return HomepageAppButtonFactory::new();
    // }
}
