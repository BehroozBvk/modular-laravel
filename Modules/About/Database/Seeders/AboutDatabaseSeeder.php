<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;

class AboutDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AboutIntroSeeder::class,
            AboutSectionSeeder::class,
            AboutTeamSettingSeeder::class,
            AboutTeamMemberSeeder::class,
            AboutPartnerSeeder::class,
        ]);
    }
}
