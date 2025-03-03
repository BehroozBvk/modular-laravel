<?php

declare(strict_types=1);

namespace Modules\Teacher\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Country\Models\Country;
use Modules\Teacher\Models\Teacher;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\User;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip' => fake()->postcode(),
            'country_id' => Country::factory(),
            'user_id' => User::factory()->state([
                'type' => UserTypeEnum::TEACHER,
            ]),
        ];
    }
}
