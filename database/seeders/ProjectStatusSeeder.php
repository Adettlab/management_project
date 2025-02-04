<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_statuses')->insert([
            [
                'name' => 'Not Started',
                'color' => '#ffcc00', // yellow
                'is_default' => true,
            ],
            [
                'name' => 'Running',
                'color' => '#00ccff', // Blue
                'is_default' => false,
            ],
            [
                'name' => 'Maintenance',
                'color' => '#ff6600', // orange
                'is_default' => false,
            ],
            [
                'name' => 'Finish',
                'color' => '#00cc00', // green
                'is_default' => false,
            ],
        ]);
    }
}
