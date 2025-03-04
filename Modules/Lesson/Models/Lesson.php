<?php

declare(strict_types=1);

namespace Modules\Lesson\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Lesson\Database\Factories\LessonFactory;

final class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'teacher_id',
        'student_id',
        'surah',
        'ayah_from',
        'ayah_to',
        'date',
        'homework',
        'feedback',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'ayah_from' => 'integer',
        'ayah_to' => 'integer',
        'teacher_id' => 'integer',
        'student_id' => 'integer',
    ];

    /**
     * Get the progress records for the lesson.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return LessonFactory::new();
    }
}
