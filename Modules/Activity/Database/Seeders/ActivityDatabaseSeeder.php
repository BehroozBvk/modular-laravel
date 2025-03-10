<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Main seeder for Activity module
 */
class ActivityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ActivitySeeder::class,
        ]);
    }
}
