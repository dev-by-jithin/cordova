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

                if (in_array($modeId, [1, 2, 3])) {
                    $rate = 30;
                    $admin = 10;
                    $superAgent = 10;
                    $agent = 10;
                } else {
                    $rate = 10;
                    $admin = 5;
                    $superAgent = 2;
                    $agent = 3;
                }

                $data[] = [
                    'ticket_id' => $ticketId,
                    'mode_id' => $modeId,
                    'scheme_id' => 1,
                    'rate' => $rate,
                    'admin_amount' => $admin,
                    'super_agent_amount' => $superAgent,
                    'agent_amount' => $agent,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Rate::upsert(
            $data,
            ['ticket_id', 'mode_id', 'scheme_id'],
            [
                'rate',
                'admin_amount',
                'super_agent_amount',
                'agent_amount',
                'updated_at'
            ]
        );
    }
}
