<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskLevel;

class TaskLevelSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $levels = [
      ['name' => 'Low', 'color' => '#6FAEC9','duration'=> '7200'],  // blue
      ['name' => 'Medium', 'color' => '#FFB42E','duration'=> '21600'], // Yellow
      ['name' => 'High', 'color' => '#EA4949','duration'=> '21600'],  // Red
    ];


    foreach ($levels as $level) {
      TaskLevel::create($level);
    }
  }
}
