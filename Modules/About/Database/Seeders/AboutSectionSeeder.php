<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\AboutSection;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create About Sections
        $sections = [
            [
                'icon_path' => 'images/about/icons/mission.svg',
                'order' => 1,
                'translations' => [
                    [
                        'locale' => 'en',
                        'title' => 'Our Mission',
                        'description' => 'To empower students with the tools and knowledge they need to succeed in a rapidly changing world.',
                    ],
                    [
                        'locale' => 'ar',
                        'title' => 'مهمتنا',
                        'description' => 'تمكين الطلاب بالأدوات والمعرفة التي يحتاجونها للنجاح في عالم سريع التغير.',
                    ],
                ],
            ],
            [
                'icon_path' => 'images/about/icons/vision.svg',
                'order' => 2,
                'translations' => [
                    [
                        'locale' => 'en',
                        'title' => 'Our Vision',
                        'description' => 'To be the global leader in educational technology, making quality education accessible to everyone.',
                    ],
                    [
                        'locale' => 'ar',
                        'title' => 'رؤيتنا',
                        'description' => 'أن نكون الرائد العالمي في تكنولوجيا التعليم، مما يجعل التعليم الجيد متاحًا للجميع.',
                    ],
                ],
            ],
            [
                'icon_path' => 'images/about/icons/values.svg',
                'order' => 3,
                'translations' => [
                    [
                        'locale' => 'en',
                        'title' => 'Our Values',
                        'description' => 'Innovation, integrity, inclusivity, and excellence in everything we do.',
                    ],
                    [
                        'locale' => 'ar',
                        'title' => 'قيمنا',
                        'description' => 'الابتكار والنزاهة والشمولية والتميز في كل ما نقوم به.',
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionData) {
            $section = AboutSection::create([
                'icon_path' => $sectionData['icon_path'],
                'order' => $sectionData['order'],
            ]);

            foreach ($sectionData['translations'] as $translation) {
                $section->translations()->create($translation);
            }
        }
    }
}

