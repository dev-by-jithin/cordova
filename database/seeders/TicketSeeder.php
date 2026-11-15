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
                'id' => 1,
                'name' => 'DEAR 1 PM',
                'short_name' => '1 PM',
                'result_time' => '13:00:00',
                'sort_order' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'KERALA 3 PM',
                'short_name' => '3 PM',
                'result_time' => '15:00:00',
                'sort_order' => 2,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'name' => 'DEAR 6 PM',
                'short_name' => '6 PM',
                'result_time' => '18:00:00',
                'sort_order' => 3,
                'created_at' => now()
            ],
            [
                'id' => 8,
                'name' => 'DEAR 8 PM',
                'short_name' => '8 PM',
                'result_time' => '20:00:00',
                'sort_order' => 4,
                'created_at' => now()
            ]
        ]);
    }
}
