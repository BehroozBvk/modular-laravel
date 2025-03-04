<?php

declare(strict_types=1);

namespace Modules\Lesson\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Modules\Lesson\Models\Lesson;
use Modules\Lesson\Models\LessonProgress;

/**
 * @extends Factory<LessonProgress>
 */
class LessonProgressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LessonProgress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random lesson or use ID 1 if none exists
        $lesson = Lesson::inRandomOrder()->first();
        $lessonId = $lesson?->id ?? 1;
        $studentId = $lesson?->student_id ?? DB::table('users')->inRandomOrder()->first()?->id ?? 1;

        return [
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
            'memorization_level' => $this->faker->numberBetween(1, 10),
            'recitation_quality' => $this->faker->numberBetween(1, 10),
            'mistakes_count' => $this->faker->numberBetween(0, 15),
            'notes' => $this->faker->boolean(70) ? $this->faker->paragraph() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
