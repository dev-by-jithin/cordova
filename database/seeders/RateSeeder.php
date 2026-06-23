<?php

namespace Database\Seeders;

use App\Models\Mode;
use App\Models\Rate;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::pluck('id');
        $modes = Mode::pluck('id');

        $data = [];

        foreach ($tickets as $ticketId) {
            foreach ($modes as $modeId) {

                $rate = in_array($modeId, [1, 2, 3]) ? 30 : 10;

                $data[] = [
                    'ticket_id' => $ticketId,
                    'mode_id' => $modeId,
                    'rate' => $rate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Rate::upsert(
            $data,
            ['ticket_id', 'mode_id'],
            ['rate', 'updated_at']
        );
    }
}
