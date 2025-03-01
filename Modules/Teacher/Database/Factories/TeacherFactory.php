<?php

declare(strict_types=1);

namespace Modules\Teacher\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Teacher\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Teacher\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
