<?php

namespace Database\Seeders;

use App\Models\Mode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mode::insert([
            [
                'group_id' => 1,
                'name' => 'A',
                'sort_order' => 3,
                'created_at' => now()
            ],
            [
                'group_id' => 1,
                'name' => 'B',
                'sort_order' => 2,
                'created_at' => now()
            ],
            [
                'group_id' => 1,
                'name' => 'C',
                'sort_order' => 1,
                'created_at' => now()
            ],
            [
                'group_id' => 2,
                'name' => 'AB',
                'sort_order' => 6,
                'created_at' => now()
            ],
            [
                'group_id' => 2,
                'name' => 'BC',
                'sort_order' => 5,
                'created_at' => now()
            ],
            [
                'group_id' => 2,
                'name' => 'AC',
                'sort_order' => 4,
                'created_at' => now()
            ],
            [
                'group_id' => 3,
                'name' => 'BOX',
                'sort_order' => 7,
                'created_at' => now()
            ],
            [
                'group_id' => 3,
                'name' => 'SUPER',
                'sort_order' => 8,
                'created_at' => now()
            ]
        ]);
    }
}
