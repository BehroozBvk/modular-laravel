<?php

declare(strict_types=1);

namespace Modules\About\Database\Factories;

use Modules\About\Models\AboutPartner;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AboutPartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutPartner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'icon_path' => 'images/about/partners/partner.svg',
            'link' => $this->faker->url(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (AboutPartner $partner) {
            $partner->translateOrNew('en')->name = $this->faker->company();

            $partner->translateOrNew('ar')->name = 'اسم الشريك';

            $partner->save();
        });
    }
}
