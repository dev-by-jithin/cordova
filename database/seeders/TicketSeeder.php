<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::insert([
            [
                'name' => 'DEAR 1 PM',
                'short_name' => 'DEAR 1',
                'result_time' => '13:00:00',
                'sort_order' => 1,
                'is_active' => 'Yes',
                'created_at' => now()
            ],
            [
                'name' => 'DEAR 6 PM',
                'short_name' => 'DEAR 6',
                'result_time' => '18:00:00',
                'sort_order' => 2,
                'is_active' => 'Yes',
                'created_at' => now()
            ],
            [
                'name' => 'DEAR 8 PM',
                'short_name' => 'DEAR 8',
                'result_time' => '20:00:00',
                'sort_order' => 3,
                'is_active' => 'Yes',
                'created_at' => now()
            ],
            [
                'name' => 'LSK 3 PM',
                'short_name' => 'LSK 3',
                'result_time' => '15:00:00',
                'sort_order' => 4,
                'is_active' => 'Yes',
                'created_at' => now()
            ],
        ]);
    }
}
