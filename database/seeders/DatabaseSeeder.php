<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // Buat Admin
    \App\Models\User::create([
        'name' => 'Admin Dinas',
        'email' => 'admin@etalase.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
   \App\Models\User::factory(5)->create()->each(function ($user) {
        // Logika membuat UMKM dummy untuk user ini
    });
}
}
