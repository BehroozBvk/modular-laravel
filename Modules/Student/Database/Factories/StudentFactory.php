<?php

declare(strict_types=1);

namespace Modules\Student\Database\Factories;

use Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

final class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
