<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('oauth_clients')->insert([
            'id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'user_id' => null,
            'name' => 'Baraeim Backend Password Grant Client',
            'secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'provider' => 'users',
            'redirect' => env('APP_URL'),
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'user_id' => null,
            'name' => 'Baraeim Backend Personal Access Client',
            'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
            'provider' => null,
            'redirect' => env('APP_URL'),
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
