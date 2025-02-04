<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Analyst'],
            ['name' => 'Project Director'],
            ['name' => 'Designer'],
            ['name' => 'Engineer Web'],
            ['name' => 'Engineer Mobile'],
            ['name' => 'Engineer Tester'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

