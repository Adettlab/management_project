<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Pelaporan PDDIKTI'],
            ['name' => 'KEPALA PUSTIK'],
            ['name' => 'Asisten DOSEN'],
            ['name' => 'TEKNISI'],
            ['name' => 'Jaringan Dan Instalasi'],
            ['name' => 'Pengelola Sosial Media'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

