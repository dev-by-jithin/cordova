<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.dashboard');
    }

    public function dashboardDetails(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        if (isset($startDate) && isset($endDate)) {
            $summary = Number::whereBetween('ticket_date', [$startDate, $endDate])
                ->selectRaw(' SUM(collection) as collection,
        SUM(a_commission) as a_commission,
        SUM(sa_commission) as sa_commission,
        SUM(sa_rate) as sa_rate,
        SUM(a_prize_commission) as a_prize_commission,
        SUM(winner_prize) as winner_prize,
        sum(count) as total_numbers,
        SUM(CASE WHEN mode_id = 1 THEN 1 ELSE 0 END) as mode_a,
        SUM(CASE WHEN mode_id = 2 THEN 1 ELSE 0 END) as mode_b,
        SUM(CASE WHEN mode_id = 3 THEN 1 ELSE 0 END) as mode_c,
        SUM(CASE WHEN mode_id = 4 THEN 1 ELSE 0 END) as mode_ab,
        SUM(CASE WHEN mode_id = 5 THEN 1 ELSE 0 END) as mode_bc,
        SUM(CASE WHEN mode_id = 6 THEN 1 ELSE 0 END) as mode_ac,
        SUM(CASE WHEN mode_id = 7 THEN 1 ELSE 0 END) as mode_box,
        SUM(CASE WHEN mode_id = 8 THEN 1 ELSE 0 END) as mode_super ')
                ->first();
        } else {
            $summary = Number::selectRaw(' SUM(collection) as collection,
        SUM(a_commission) as a_commission,
        SUM(sa_commission) as sa_commission,
        SUM(sa_rate) as sa_rate,
        SUM(a_prize_commission) as a_prize_commission,
        SUM(winner_prize) as winner_prize,
        sum(count) as total_numbers,
        SUM(CASE WHEN mode_id = 1 THEN 1 ELSE 0 END) as mode_a,
        SUM(CASE WHEN mode_id = 2 THEN 1 ELSE 0 END) as mode_b,
        SUM(CASE WHEN mode_id = 3 THEN 1 ELSE 0 END) as mode_c,
        SUM(CASE WHEN mode_id = 4 THEN 1 ELSE 0 END) as mode_ab,
        SUM(CASE WHEN mode_id = 5 THEN 1 ELSE 0 END) as mode_bc,
        SUM(CASE WHEN mode_id = 6 THEN 1 ELSE 0 END) as mode_ac,
        SUM(CASE WHEN mode_id = 7 THEN 1 ELSE 0 END) as mode_box,
        SUM(CASE WHEN mode_id = 8 THEN 1 ELSE 0 END) as mode_super ')
                ->first();
        }


        return response()->json([
            'collection' => (float) $summary->collection,
            'a_commission' => (float) $summary->a_commission,
            'sa_commission' => (float) $summary->sa_commission,
            'admin' => (float) ($summary->sa_rate - ($summary->a_prize_commission + $summary->winner_prize)),
            'winner' => (float) $summary->a_prize_commission + $summary->winner_prize,
            'a_total' => $summary->mode_a,
            'b_total' => $summary->mode_b,
            'c_total' => $summary->mode_c,
            'ab_total' => $summary->mode_ab,
            'bc_total' => $summary->mode_bc,
            'ac_total' => $summary->mode_ac,
            'box_total' => $summary->mode_box,
            'super_total' => $summary->mode_super,
            'total_count' => $summary->total_numbers
        ]);
    }
}
