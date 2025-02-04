<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProjectStatusSeeder::class,
            UserSeeder::class,
            ProjectLevelSeeder::class,
            RoleSeeder::class,
            EmployeeSeeder::class,
            TaskLevelSeeder::class,
            TaskStatusSeeder::class,
            LeaveSeeder::class,
        ]);
    }
}
