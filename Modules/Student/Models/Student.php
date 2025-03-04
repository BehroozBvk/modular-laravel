<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Lesson\Models\Lesson;
use Modules\Lesson\Models\LessonProgress;
use Modules\Student\Database\Factories\StudentFactory;
use Modules\StudentParent\Models\StudentParent;
use Modules\User\Models\User;

class Student extends Model
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
        'student_parent_id',
        'user_id',
        'first_name',
        'last_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(StudentParent::class, 'student_parent_id');
    }

    /**
     * Get the lessons for the student.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get the lesson progress records for the student.
     */
    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Get the student's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    protected static function newFactory(): StudentFactory
    {
        return StudentFactory::new();
    }
}
