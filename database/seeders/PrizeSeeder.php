<?php

namespace Database\Seeders;

use App\Models\Mode;
use App\Models\Prize;
use Illuminate\Database\Seeder;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = Mode::select('id', 'group_id')->get();

        foreach ($modes as $mode) {
            if ($mode->group_id == 1) {
                Prize::insert([
                    'mode_id' => $mode->id,
                    'position' => 1,
                    'count' => 1,
                    'prize' => 100,
                    'agent_commission' => 0,
                    'created_at' => now()
                ]);
            }

            if ($mode->group_id == 2) {
                Prize::insert([
                    'mode_id' => $mode->id,
                    'position' => 1,
                    'count' => 1,
                    'prize' => 700,
                    'agent_commission' => 30,
                    'created_at' => now()
                ]);
            }

            if ($mode->group_id == 3 && $mode->id == 7) {
                Prize::insert([
                    [
                        'mode_id' => $mode->id,
                        'position' => 1,
                        'count' => 1,
                        'prize' => 3000,
                        'agent_commission' => 300,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 2,
                        'count' => 1,
                        'prize' => 800,
                        'agent_commission' => 30,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 3,
                        'count' => 1,
                        'prize' => 800,
                        'agent_commission' => 30,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 4,
                        'count' => 1,
                        'prize' => 800,
                        'agent_commission' => 30,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 5,
                        'count' => 1,
                        'prize' => 800,
                        'agent_commission' => 30,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 6,
                        'count' => 1,
                        'prize' => 800,
                        'agent_commission' => 30,
                        'created_at' => now()
                    ],
                ]);
            }

            if ($mode->group_id == 3 && $mode->id == 8) {
                Prize::insert([
                    [
                        'mode_id' => $mode->id,
                        'position' => 1,
                        'count' => 1,
                        'prize' => 5000,
                        'agent_commission' => 400,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 2,
                        'count' => 1,
                        'prize' => 500,
                        'agent_commission' => 50,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 3,
                        'count' => 1,
                        'prize' => 250,
                        'agent_commission' => 20,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 4,
                        'count' => 1,
                        'prize' => 100,
                        'agent_commission' => 20,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 5,
                        'count' => 1,
                        'prize' => 50,
                        'agent_commission' => 20,
                        'created_at' => now()
                    ],
                    [
                        'mode_id' => $mode->id,
                        'position' => 6,
                        'count' => 1,
                        'prize' => 20,
                        'agent_commission' => 10,
                        'created_at' => now()
                    ],
                ]);
            }
        }
    }
}
