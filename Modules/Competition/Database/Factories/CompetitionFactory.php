<?php

declare(strict_types=1);

namespace Modules\Competition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Models\Competition;

final class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image_path' => $this->faker->imageUrl,
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
