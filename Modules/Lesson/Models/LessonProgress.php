<?php

declare(strict_types=1);

namespace Modules\Lesson\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Lesson\Database\Factories\LessonProgressFactory;

final class LessonProgress extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lesson_id',
        'student_id',
        'memorization_level',
        'recitation_quality',
        'mistakes_count',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'lesson_id' => 'integer',
            'student_id' => 'integer',
            'memorization_level' => 'integer',
            'recitation_quality' => 'integer',
            'mistakes_count' => 'integer',
        ];
    }

    /**
     * Get the lesson that owns the progress record.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return LessonProgressFactory::new();
    }
}
