<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\AboutTeamSetting;

class AboutTeamSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Team Settings
        AboutTeamSetting::create([
            'visible' => true,
        ]);
    }
}
