<?php

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Activity\Database\Factories\ActivityAttachmentFactory;

class ActivityAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): ActivityAttachmentFactory
    // {
    //     // return ActivityAttachmentFactory::new();
    // }
}
