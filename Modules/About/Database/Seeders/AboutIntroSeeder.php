<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\AboutIntro;

class AboutIntroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create About Intro
        $intro = AboutIntro::create([
            'image_path' => 'images/about/intro.jpg',
            'background_path' => 'images/about/intro-bg.jpg',
        ]);

        // Create translations for intro
        $intro->translations()->createMany([
            [
                'locale' => 'en',
                'title' => 'About Our Company',
                'description' => 'We are a leading educational technology company dedicated to providing innovative learning solutions for students of all ages.',
            ],
            [
                'locale' => 'ar',
                'title' => 'عن شركتنا',
                'description' => 'نحن شركة تكنولوجيا تعليمية رائدة مكرسة لتوفير حلول تعليمية مبتكرة للطلاب من جميع الأعمار.',
            ],
        ]);
    }
}
