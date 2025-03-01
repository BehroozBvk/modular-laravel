<?php

namespace Modules\StudentParent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Country\Models\Country;
use Modules\Student\Models\Student;
use Modules\StudentParent\Database\Factories\StudentParentFactory;
use Modules\User\Models\User;

class StudentParent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country_id',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    protected static function newFactory(): StudentParentFactory
    {
        return StudentParentFactory::new();
    }
}
