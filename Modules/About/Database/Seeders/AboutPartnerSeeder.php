<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\AboutPartner;

class AboutPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Partners
        $partners = [
            [
                'icon_path' => 'images/about/partners/partner1.svg',
                'link' => 'https://partner1.com',
                'order' => 1,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'Partner One',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'الشريك الأول',
                    ],
                ],
            ],
            [
                'icon_path' => 'images/about/partners/partner2.svg',
                'link' => 'https://partner2.com',
                'order' => 2,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'Partner Two',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'الشريك الثاني',
                    ],
                ],
            ],
            [
                'icon_path' => 'images/about/partners/partner3.svg',
                'link' => 'https://partner3.com',
                'order' => 3,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'Partner Three',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'الشريك الثالث',
                    ],
                ],
            ],
        ];

        foreach ($partners as $partnerData) {
            $partner = AboutPartner::create([
                'icon_path' => $partnerData['icon_path'],
                'link' => $partnerData['link'],
                'order' => $partnerData['order'],
            ]);

            foreach ($partnerData['translations'] as $translation) {
                $partner->translations()->create($translation);
            }
        }
    }
}

