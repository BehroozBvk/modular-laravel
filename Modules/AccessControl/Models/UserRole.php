<?php

namespace Modules\AccessControl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\AccessControl\Database\Factories\UserRoleFactory;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): UserRoleFactory
    // {
    //     // return UserRoleFactory::new();
    // }
}
