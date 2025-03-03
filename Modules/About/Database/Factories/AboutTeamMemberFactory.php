<?php

declare(strict_types=1);

namespace Modules\About\Database\Factories;

use Modules\About\Models\AboutTeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AboutTeamMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AboutTeamMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'image_path' => 'images/about/team/member.jpg',
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
        return $this->afterCreating(function (AboutTeamMember $member) {
            $member->translateOrNew('en')->name = $this->faker->name();
            $member->translateOrNew('en')->position = $this->faker->jobTitle();

            $member->translateOrNew('ar')->name = 'اسم العضو';
            $member->translateOrNew('ar')->position = 'المنصب الوظيفي';

            $member->save();
        });
    }
}
