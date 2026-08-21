<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'adm',
            'password' => bcrypt('12345678'),
            'role' => 'Admin',
            'created_at' => now()
        ]);

        User::insert([
            'name' => 'Jithin',
            'email' => null,
            'username' => 'jit',
            'password' => bcrypt('122'),
            'decrypted' => '122',
            'scheme_id' => 1,
            'role' => 'Super Agent',
            'created_at' => now()
        ]);
    }
}
