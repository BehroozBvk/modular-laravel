<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\AboutTeamMember;

class AboutTeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Team Members
        $teamMembers = [
            [
                'image_path' => 'images/about/team/member1.jpg',
                'order' => 1,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'John Doe',
                        'position' => 'CEO & Founder',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'جون دو',
                        'position' => 'الرئيس التنفيذي والمؤسس',
                    ],
                ],
            ],
            [
                'image_path' => 'images/about/team/member2.jpg',
                'order' => 2,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'Jane Smith',
                        'position' => 'CTO',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'جين سميث',
                        'position' => 'المدير التقني',
                    ],
                ],
            ],
            [
                'image_path' => 'images/about/team/member3.jpg',
                'order' => 3,
                'translations' => [
                    [
                        'locale' => 'en',
                        'name' => 'Michael Johnson',
                        'position' => 'COO',
                    ],
                    [
                        'locale' => 'ar',
                        'name' => 'مايكل جونسون',
                        'position' => 'مدير العمليات',
                    ],
                ],
            ],
        ];

        foreach ($teamMembers as $memberData) {
            $member = AboutTeamMember::create([
                'image_path' => $memberData['image_path'],
                'order' => $memberData['order'],
            ]);

            foreach ($memberData['translations'] as $translation) {
                $member->translations()->create($translation);
            }
        }
    }
}

