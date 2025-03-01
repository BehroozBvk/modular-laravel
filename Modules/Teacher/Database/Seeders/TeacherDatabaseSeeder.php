<?php

declare(strict_types=1);

namespace Modules\Teacher\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Teacher\Models\Teacher;
use Modules\User\Enums\UserTypeEnum;
use Modules\User\Models\User;

class TeacherDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating test teachers...');

        DB::transaction(function (): void {
            // Create admin teacher account
            $adminTeacher = Teacher::factory()->create([
                'user_id' => User::factory()->create([
                    'name' => 'Admin Teacher',
                    'email' => 'admin.teacher@baraeim.com',
                    'type' => UserTypeEnum::TEACHER,
                    'email_verified_at' => now(),
                ]),
            ]);

            $this->command->info("Created admin teacher: {$adminTeacher->user->email}");

            // Create test teachers
            $teachers = Teacher::factory()
                ->count(10)
                ->create();

            $this->command->info("Created {$teachers->count()} test teachers");
        });

        $this->command->info('Teachers seeded successfully!');
    }
}
