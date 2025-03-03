<?php

declare(strict_types=1);

namespace Modules\About\Database\Factories;

use Modules\About\Models\AboutTeamSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AboutTeamSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutTeamSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'visible' => true,
        ];
    }
}
