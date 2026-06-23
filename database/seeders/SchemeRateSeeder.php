<?php

namespace Database\Seeders;

use App\Models\Rate;
use App\Models\Scheme;
use App\Models\SchemeRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchemeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schemes = Scheme::select('id')
            ->where('is_active', 'Yes')
            ->get();

        $rates = Rate::select('id', 'rate')->get();

        $data = [];

        foreach ($schemes as $scheme) {
            foreach ($rates as $rate) {

                if ($rate->rate == 10) {
                    $adminAmount = 5;
                    $superAgentAmount = 2;
                    $agentAmount = 3;
                } else {
                    $adminAmount = 10;
                    $superAgentAmount = 10;
                    $agentAmount = 10;
                }

                $data[] = [
                    'scheme_id' => $scheme->id,
                    'rate_id' => $rate->id,
                    'admin_amount' => $adminAmount,
                    'super_agent_amount' => $superAgentAmount,
                    'agent_amount' => $agentAmount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        SchemeRate::upsert(
            $data,
            ['scheme_id', 'rate_id'],
            ['admin_amount', 'super_agent_amount', 'agent_amount', 'updated_at']
        );
    }
}
