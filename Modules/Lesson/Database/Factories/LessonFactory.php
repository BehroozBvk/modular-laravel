<?php

declare(strict_types=1);

namespace Modules\Lesson\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Modules\Lesson\Models\Lesson;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random user IDs from the database for teacher and student
        $teacherId = DB::table('users')->inRandomOrder()->first()?->id ?? 1;
        $studentId = DB::table('users')->where('id', '!=', $teacherId)->inRandomOrder()->first()?->id ?? 2;

        return [
            'teacher_id' => $teacherId,
            'student_id' => $studentId,
            'surah' => $this->faker->randomElement(['Al-Fatihah', 'Al-Baqarah', 'Al-Imran', 'An-Nisa', 'Al-Ma\'idah']),
            'ayah_from' => $this->faker->numberBetween(1, 50),
            'ayah_to' => function (array $attributes) {
                return $this->faker->numberBetween($attributes['ayah_from'], $attributes['ayah_from'] + 20);
            },
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'homework' => $this->faker->boolean(70) ? $this->faker->paragraph() : null,
            'feedback' => $this->faker->boolean(60) ? $this->faker->paragraph() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
