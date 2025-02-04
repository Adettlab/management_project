<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectLevel;

class ProjectLevelSeeder extends Seeder
{
  public function run()
  {
    $levels = [
      ['name' => 'Low', 'color' => '#6FAEC9'],  // blue
      ['name' => 'Medium', 'color' => '#FFB42E'], // Yellow
      ['name' => 'High', 'color' => '#EA4949'],  // Red
    ];

    foreach ($levels as $level) {
      ProjectLevel::create($level);
    }
  }
}
