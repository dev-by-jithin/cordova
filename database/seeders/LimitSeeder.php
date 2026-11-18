<?php

namespace Database\Seeders;

use App\Models\Limit;
use Illuminate\Database\Seeder;

class LimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Limit::insert([
            [
                'mode_id' => 1,
                'limit' => 200,
                'created_at' => now()
            ],
            [
                'mode_id' => 2,
                'limit' => 200,
                'created_at' => now()
            ],
            [
                'mode_id' => 3,
                'limit' => 200,
                'created_at' => now()
            ],
            [
                'mode_id' => 4,
                'limit' => 50,
                'created_at' => now()
            ],
            [
                'mode_id' => 5,
                'limit' => 50,
                'created_at' => now()
            ],
            [
                'mode_id' => 6,
                'limit' => 50,
                'created_at' => now()
            ],
            [
                'mode_id' => 7,
                'limit' => 10,
                'created_at' => now()
            ],
            [
                'mode_id' => 8,
                'limit' => 10,
                'created_at' => now()
            ]
        ]);
    }
}
