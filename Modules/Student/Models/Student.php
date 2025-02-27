<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\StudentParent\Models\StudentParent;
use Modules\Student\Database\Factories\StudentFactory;

class Student extends Model
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
        'student_parent_id',
    ];

    public function parents(): BelongsTo
    {
        return $this->belongsTo(StudentParent::class);
    }

    protected static function newFactory(): StudentFactory
    {
        return StudentFactory::new();
    }
}
