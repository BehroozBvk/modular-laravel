<?php

namespace Modules\AccessControl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\AccessControl\Database\Factories\UserPermissionFactory;

class UserPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): UserPermissionFactory
    // {
    //     // return UserPermissionFactory::new();
    // }
}
