<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Activity\Models\Activity;

/**
 * Factory for Activity model
 */
class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'slug' => Str::slug($title),
            'main_image_path' => 'activities/main/' . $this->faker->uuid() . '.jpg',
            'cover_image_path' => 'activities/covers/' . $this->faker->uuid() . '.jpg',
            'video_path' => $this->faker->optional(0.7)->passthrough('activities/videos/' . $this->faker->uuid() . '.mp4'),
            'activity_time' => $this->faker->optional(0.8)->dateTimeBetween('now', '+3 months'),
            'alt_image_path' => 'activities/alt/' . $this->faker->uuid() . '.jpg',
            'points' => $this->faker->numberBetween(5, 50),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Activity $activity) {
            // Create Arabic translation
            $activity->translateOrNew('ar')->title = 'عنوان النشاط ' . $activity->id;
            $activity->translateOrNew('ar')->short_description = 'نبذة مختصرة عن النشاط ' . $activity->id;
            $activity->translateOrNew('ar')->category = 'تصنيف ' . $activity->id;
            $activity->translateOrNew('ar')->description = 'وصف تفصيلي للنشاط ' . $activity->id . ' ' . $this->faker->paragraphs(3, true);
            $activity->translateOrNew('ar')->activity_type = $activity->id % 2 === 0 ? 'لقاء واحد' : 'دورة';
            $activity->translateOrNew('ar')->meta_title = 'العنوان التعريفي ' . $activity->id;
            $activity->translateOrNew('ar')->meta_description = 'وصف تعريفي للنشاط ' . $activity->id;
            $activity->translateOrNew('ar')->meta_tags = 'نشاط, تعليم, تدريب, ' . $activity->id;

            // Create English translation
            $activity->translateOrNew('en')->title = 'Activity Title ' . $activity->id;
            $activity->translateOrNew('en')->short_description = 'Short description for activity ' . $activity->id;
            $activity->translateOrNew('en')->category = 'Category ' . $activity->id;
            $activity->translateOrNew('en')->description = 'Detailed description for activity ' . $activity->id . ' ' . $this->faker->paragraphs(3, true);
            $activity->translateOrNew('en')->activity_type = $activity->id % 2 === 0 ? 'Single Session' : 'Course';
            $activity->translateOrNew('en')->meta_title = 'Meta Title ' . $activity->id;
            $activity->translateOrNew('en')->meta_description = 'Meta description for activity ' . $activity->id;
            $activity->translateOrNew('en')->meta_tags = 'activity, education, training, ' . $activity->id;

            $activity->save();
        });
    }
}
