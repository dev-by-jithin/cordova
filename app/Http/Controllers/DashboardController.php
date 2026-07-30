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
            $summary = Number::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->selectRaw(' SUM(collection_total) as collection_total,
        SUM(a_commission_total) as a_commission_total,
        SUM(sa_commission_total) as sa_commission_total,
        SUM(sa_rate_total) as sa_rate_total,
        COUNT(*) as total_numbers,
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
            $summary = Number::selectRaw(' SUM(collection_total) as collection_total,
        SUM(a_commission_total) as a_commission_total,
        SUM(sa_commission_total) as sa_commission_total,
        SUM(sa_rate_total) as sa_rate_total,
        COUNT(*) as total_numbers,
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
            'collection_total' => (float) $summary->collection_total,
            'a_commission_total' => (float) $summary->a_commission_total,
            'sa_commission_total' => (float) $summary->sa_commission_total,
            'admin_total' => (float) $summary->sa_rate_total,
            'winner_total' => 0,
            'a_total' => $summary->mode_a,
            'b_total' => $summary->mode_b,
            'c_total' => $summary->mode_c,
            'ab_total' => $summary->mode_ab,
            'bc_total' => $summary->mode_bc,
            'ac_total' => $summary->mode_ac,
            'box_total' => $summary->mode_box,
            'super_total' => $summary->mode_super
        ]);
    }
}
