<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Password Grant Client
        DB::table('oauth_clients')->insert([
            'id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'user_id' => null,
            'name' => 'Baraeim Backend Password Grant Client',
            'secret' => '$2y$10$' . Str::random(53), // Hash of the secret (actual value stored in .env)
            'provider' => 'users',
            'redirect' => env('APP_URL'),
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Personal Access Client
        DB::table('oauth_clients')->insert([
            'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'user_id' => null,
            'name' => 'Baraeim Backend Personal Access Client',
            'secret' => '$2y$10$' . Str::random(53), // Hash of the secret (actual value stored in .env)
            'provider' => null,
            'redirect' => env('APP_URL'),
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add Personal Access Client record
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
