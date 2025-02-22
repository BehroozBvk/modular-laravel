<?php

namespace Modules\StudentParent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\StudentParent\Database\Factories\StudentParentFactory;

class StudentParent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): StudentParentFactory
    // {
    //     // return StudentParentFactory::new();
    // }
}
