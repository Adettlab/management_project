<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
  public function run()
  {
    // Temukan role berdasarkan nama
    $roles = [
      'Pelaporan PDDIKTI' => Role::where('name', 'Pelaporan PDDIKTI')->first(),
      'KEPALA PUSTIK' => Role::where('name', 'KEPALA PUSTIK')->first(),
      'Asisten DOSEN' => Role::where('name', 'Asisten DOSEN')->first(),
      'Jaringan Dan Instalasi' => Role::where('name', 'Jaringan Dan Instalasi')->first(),
      'TEKNISI' => Role::where('name', 'TEKNISI')->first(),
      'Pengelola Sosial Media' => Role::where('name', 'Pengelola Sosial Media')->first(),
    ];

    // Data employees
    $employees = [
      // KEPALA PUSTIK (role akan diubah ke admin di tabel users)
      ['name' => 'Cristeddy Asa Bakti', 'role' => 'KEPALA PUSTIK'],

      // pelaporan PDDIKTI
      ['name' => 'Ani Herdayati', 'role' => 'Pelaporan PDDIKTI'],
      
      // Asisten DOSEN
      ['name' => 'Dina Hapsari', 'role' => 'Asisten DOSEN'],

      // TEKNISI
      ['name' => 'Rizal Faidzin Firdaus', 'role' => 'TEKNISI'],
      ['name' => 'Albertus Mathew Andrew', 'role' => 'TEKNISI'],
      ['name' => 'Steven Oscar Dharmasetiana', 'role' => 'TEKNISI'],

      // Jaringan Dan Instalasi
      ['name' => 'Michael Ade Suswondo', 'role' => 'Jaringan Dan Instalasi'],

      // Pengelola Sosial Media
      ['name' => 'Yeri Prayudi', 'role' => 'Pengelola Sosial Media'],
    ];

    // Kumpulkan data untuk users
    $usersData = [];
    $employeesData = [];

    foreach ($employees as $employeeData) {
      $role = $employeeData['role'] === 'KEPALA PUSTIK' ? 'admin' : 'user'; // Ubah role ke admin untuk KEPALA PUSTIK

      $usersData[] = [
        'name' => $employeeData['name'], // Username
        'email' => strtolower($employeeData['name']) . '@example.com', // Dummy email
        'password' => Hash::make('password123'), // Dummy password
        'role' => $role, // Role admin untuk KEPALA PUSTIK
        'created_at' => now(), // Tambahkan timestamp untuk insert
        'updated_at' => now(),
      ];
    }

    // Insert data ke tabel users
    User::insert($usersData);

    // Ambil semua user yang baru saja dimasukkan
    $insertedUsers = User::whereIn('email', array_column($usersData, 'email'))->get();

    // Buat mapping untuk mencocokkan user dan employee
    foreach ($insertedUsers as $index => $user) {
      $employeeData = $employees[$index];

      $employeesData[] = [
        'user_id' => $user->id,
        'role_id' => $roles[$employeeData['role']]->id,
        'work_email' => strtolower($employeeData['name']) . '@company.com', // Dummy work email
        'photo' => null,
        'nik' => null,
        'status' => null,
        'birth_date' => null,
        'phone_number' => null,
        'telegram_link' => null,
        'address' => null,
        'join_date' => null,
        'education' => null,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // Insert data ke tabel employees
    Employee::insert($employeesData);
  }
}
