<?php

declare(strict_types=1);

namespace Modules\StudentParent\Database\Factories;

use Modules\StudentParent\Models\StudentParent;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentParentFactory extends Factory
{
    protected $model = StudentParent::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
    }
}
