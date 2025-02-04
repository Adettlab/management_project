<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'To-do', 'color' => '#ff0000 '], // Orange
            ['name' => 'In Progress', 'color' => '#e49904 '], // Blue
            ['name' => 'Review', 'color' => '#0000FF'], // Blue
            ['name' => 'Completed', 'color' => '#008000'],  // Green
        ];

        foreach ($statuses as $status) {
            TaskStatus::create($status);
        }
    }
}
