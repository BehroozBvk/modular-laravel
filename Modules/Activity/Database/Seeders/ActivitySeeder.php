<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Activity\Models\Activity;

/**
 * Seeder for Activity data
 */
class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory()->count(10)->create();
    }
}
