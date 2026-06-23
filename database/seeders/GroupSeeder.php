<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::insert([
            [
                'name' => 'Group 1',
                'created_at' => now()
            ],
            [
                'name' => 'Group 2',
                'created_at' => now()
            ],
            [
                'name' => 'Group 3',
                'created_at' => now()
            ]
        ]);
    }
}
