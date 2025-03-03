<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Passport seeder to ensure OAuth clients are available
        $this->call(PassportSeeder::class);

        // Add other seeders here
    }
}
