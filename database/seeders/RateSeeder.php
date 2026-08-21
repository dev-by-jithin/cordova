<?php

namespace Database\Seeders;

use App\Models\Mode;
use App\Models\Rate;
use App\Models\Ticket;
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

                if (in_array($modeId, [1, 2, 3])) {
                    $ticketRate = 12;
                    $rate = 10.5;
                } else {
                    $ticketRate = 10;
                    $rate = 7.7;
                }

                $data[] = [
                    'ticket_id' => $ticketId,
                    'mode_id' => $modeId,
                    'user_id' => 2,
                    'ticket_rate' => $ticketRate,
                    'rate' => $rate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Rate::upsert(
            $data,
            ['ticket_id', 'mode_id', 'user_id'],
            [
                'rate',
                'updated_at'
            ]
        );
    }
}
