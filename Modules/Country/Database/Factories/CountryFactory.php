<?php

declare(strict_types=1);

namespace Modules\Country\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Country\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Country\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => fake()->countryCode(),
            'flag' => fake()->countryCode(),
        ];
    }
}
