<?php

namespace Modules\StudentParent\Models;

use Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\StudentParent\Database\Factories\StudentParentFactory;

class StudentParent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'status',
    ];

    protected static function newFactory(): StudentParentFactory
    {
        return StudentParentFactory::new();
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
