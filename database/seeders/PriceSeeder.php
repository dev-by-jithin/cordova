<?php

namespace Database\Seeders;

use App\Models\Mode;
use App\Models\Price;
use App\Models\Scheme;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schemeId = Scheme::value('id');
        $modes = Mode::select('id', 'group_id')->get();

        foreach ($modes as $mode) {
            if ($mode->group_id == 1) {
                Price::insert([
                    'scheme_id' => $schemeId,
                    'mode_id' => $mode->id,
                    'position' => 1,
                    'count' => 1,
                    'winner_amount' => 100,
                    'super_agent_amount' => 0,
                    'agent_amount' => 0,
                    'created_at' => now()
                ]);
            }

            if ($mode->group_id == 2) {
                Price::insert([
                    'scheme_id' => $schemeId,
                    'mode_id' => $mode->id,
                    'position' => 1,
                    'count' => 1,
                    'winner_amount' => 700,
                    'super_agent_amount' => 0,
                    'agent_amount' => 30,
                    'created_at' => now()
                ]);
            }

            if ($mode->group_id == 3 && $mode->id == 7) {
                Price::insert([
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 1,
                        'count' => 1,
                        'winner_amount' => 3000,
                        'super_agent_amount' => 0,
                        'agent_amount' => 300,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 2,
                        'count' => 1,
                        'winner_amount' => 800,
                        'super_agent_amount' => 0,
                        'agent_amount' => 30,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 3,
                        'count' => 1,
                        'winner_amount' => 800,
                        'super_agent_amount' => 0,
                        'agent_amount' => 30,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 4,
                        'count' => 1,
                        'winner_amount' => 800,
                        'super_agent_amount' => 0,
                        'agent_amount' => 30,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 5,
                        'count' => 1,
                        'winner_amount' => 800,
                        'super_agent_amount' => 0,
                        'agent_amount' => 30,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 6,
                        'count' => 1,
                        'winner_amount' => 800,
                        'super_agent_amount' => 0,
                        'agent_amount' => 30,
                        'created_at' => now()
                    ],
                ]);
            }

            if ($mode->group_id == 3 && $mode->id == 8) {
                Price::insert([
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 1,
                        'count' => 1,
                        'winner_amount' => 5000,
                        'super_agent_amount' => 0,
                        'agent_amount' => 400,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 2,
                        'count' => 1,
                        'winner_amount' => 500,
                        'super_agent_amount' => 0,
                        'agent_amount' => 50,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 3,
                        'count' => 1,
                        'winner_amount' => 250,
                        'super_agent_amount' => 0,
                        'agent_amount' => 20,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 4,
                        'count' => 1,
                        'winner_amount' => 100,
                        'super_agent_amount' => 0,
                        'agent_amount' => 20,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 5,
                        'count' => 1,
                        'winner_amount' => 50,
                        'super_agent_amount' => 0,
                        'agent_amount' => 20,
                        'created_at' => now()
                    ],
                    [
                        'scheme_id' => $schemeId,
                        'mode_id' => $mode->id,
                        'position' => 6,
                        'count' => 30,
                        'winner_amount' => 20,
                        'super_agent_amount' => 0,
                        'agent_amount' => 10,
                        'created_at' => now()
                    ],
                ]);
            }
        }
    }
}
