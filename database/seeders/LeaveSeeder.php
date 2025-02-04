<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveCategories;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $leaves = [
            ['name' => 'Cuti Hari Raya'],
            ['name' => 'Cuti Sakit'],
            ['name' => 'Cuti Tahunan'],
            ['name' => 'Cuti Menikah'],
            ['name' => 'Cuti Melahirkan'],
            ['name' => 'Cuti Keguguran'],
            ['name' => 'Cuti Berduka'],
        ];

        foreach ($leaves as $leave) {
            LeaveCategories::create($leave);
        }
    }
}
