<?php

declare(strict_types=1);

namespace Modules\About\Database\Factories;

use Modules\About\Models\AboutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AboutSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'icon_path' => 'images/about/icons/section.svg',
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
        return $this->afterCreating(function (AboutSection $section) {
            $section->translateOrNew('en')->title = $this->faker->sentence(3);
            $section->translateOrNew('en')->description = $this->faker->paragraph(2);

            $section->translateOrNew('ar')->title = 'عنوان القسم';
            $section->translateOrNew('ar')->description = 'وصف القسم';

            $section->save();
        });
    }
}
