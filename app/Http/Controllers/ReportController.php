<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Number;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::select('id', 'name')->orderBy('result_time', 'ASC')->get();
        $modes = Mode::select('id', 'name')->orderBy('sort_order', 'DESC')->get();
        $superAgents = User::select('id', 'username')->where('role', 'Super Agent')->get();

        return view('report.index', compact('tickets', 'modes', 'superAgents'));
    }

    public function salesSummary(Request $request)
    {
        $query = Number::selectRaw('
                DATE(ticket_date) as sale_date,
                SUM(`count`) as total_count,
                SUM(a_rate_total) as total_amount'
        )
        ->whereDate('ticket_date', '>=', $request->fromDate)
        ->whereDate('ticket_date', '<=', $request->toDate);

        if ($request->filled('ticketId')) {
            $query->where('ticket_id', $request->ticketId);
        }
        if ($request->filled('ticketNumber')) {
            $query->where('number', $request->ticketNumber);
        }
        if ($request->filled('groupId')) {
            $query->where('group_id', $request->groupId);
        }
        if ($request->filled('modeId')) {
            $query->where('mode_id', $request->modeId);
        }
        if ($request->filled('superAgentId')) {
            $query->where('super_agent_id', $request->superAgentId);
        }
        if ($request->filled('agentId')) {
            $query->where('agent_id', $request->agentId);
        }
        $result = $query->groupBy(DB::raw('DATE(ticket_date)'))
            ->orderBy('sale_date', 'asc')
            ->get();

        return response()->json(['status' => true, 'data' => $result]);
    }
}
