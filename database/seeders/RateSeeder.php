<?php

namespace Database\Seeders;

use App\Models\Mode;
use App\Models\Rate;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = Mode::pluck('id');

        $data = [];


        foreach ($modes as $modeId) {

            if (in_array($modeId, [1, 2, 3])) {
                $ticketRate = 12;
                $SuperAgentRate = 10.5;
            } else {
                $ticketRate = 10;
                $SuperAgentRate = 7.7;
            }

            $data[] = [
                'mode_id' => $modeId,
                'user_id' => 2,
                'ticket_rate' => $ticketRate,
                'super_agent_rate' => $SuperAgentRate,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }


        Rate::upsert(
            $data,
            ['mode_id', 'user_id'],
            [
                'super_agent_rate',
                'updated_at'
            ]
        );
    }
}
