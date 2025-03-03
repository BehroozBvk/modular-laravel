<?php

declare(strict_types=1);

namespace Modules\About\Database\Factories;

use Modules\About\Models\AboutIntro;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AboutIntroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutIntro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [];
    }

    // make the configure for the afterMaking and afterCreating in order to add the translations. 
}
