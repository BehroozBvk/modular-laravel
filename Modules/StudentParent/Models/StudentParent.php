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
        'phone_number',
        'address',
        'city',
        'state',
        'zip',
        'country_id',
        'user_id',
        'first_name',
        'last_name',
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

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    protected static function newFactory(): StudentParentFactory
    {
        return StudentParentFactory::new();
    }
}
