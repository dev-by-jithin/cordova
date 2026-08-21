<?php

namespace Database\Seeders;

use App\Models\Scheme;
use Illuminate\Database\Seeder;

class SchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scheme::insert([
            [
                'name' => 'Scheme-1',
                'is_active' => 'Yes',
                'created_at' => now()
            ]
        ]);
    }
}
