<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Mode;
use App\Models\Number;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
                SUM(a_rate) as total_amount'
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

    public function salesUsers(Request $request)
    {
        $query = Number::with(['agent:id,username'])
            ->selectRaw('
                agent_id,
                SUM(`count`) as total_count,
                SUM(a_rate) as total_amount'
            )
            ->whereDate('ticket_date', $request->saleDate);

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

        $result = $query->groupBy('agent_id')
            ->orderByDesc('total_amount')
            ->get();

        return response()->json(['status' => true, 'data' => $result]);
    }

    public function salesReport(Request $request)
    {
        $bills = Bill::with([
            'ticket:id,short_name',
            'agent:id,username',
            'numbers' => function ($query) use ($request) {
                // Select only required columns from numbers
                $query->select([
                    'id',
                    'bill_id',
                    'ticket_id',
                    'mode_id',
                    'number',
                    'count',
                    'a_rate'
                ])
                    ->with(['mode:id,name']);
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
                $query->orderBy('id');
            }
        ])
            ->whereDate('ticket_date', $request->saleDate)
            ->where('agent_id', $request->agentId)
            ->orderBy('id')
            ->get();
        $report = $bills->map(function ($bill) {
            return [
                'bill_id' => $bill->id,
                'ticket' => $bill->ticket?->short_name,
                'agent' => $bill->agent?->username,
                'create_time' => $bill->created_at->format('h:i:s A'),
                'create_date' => $bill->ticket_date,
                'numbers' => $bill->numbers
            ];
        });
        return response()->json(['status' => true, 'data' => $report]);
    }

    public function winningSummary(Request $request)
    {

        $query = Number::query()
            ->whereDate('ticket_date', '>=', $request->fromDate)
            ->whereDate('ticket_date', '<=', $request->toDate);
        // Optional filters
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

        $result = $query->selectRaw('
                COALESCE(SUM(CASE WHEN winner_prize > 0 THEN `count` ELSE 0 END), 0) as winning_count,
                COALESCE(SUM(winner_prize), 0) as winning_prize,
                COALESCE(SUM(a_prize_commission), 0) as agent_prize '
        )->first();
        return response()->json([
            'status' => true,
            'data' => [
                'winning_count' => (int) $result->winning_count,
                'winning_prize' => (float) $result->winning_prize,
                'agent_prize' => (float) $result->agent_prize,
            ]
        ]);
    }

    public function winningUsers(Request $request)
    {

        $query = Number::with(['agent:id,username'])
            ->selectRaw('
                agent_id,
                COALESCE(SUM(CASE WHEN winner_prize > 0 THEN `count` ELSE 0 END), 0) as winning_count,
                COALESCE(SUM(winner_prize), 0) as winning_prize,
                COALESCE(SUM(a_prize_commission), 0) as agent_prize'
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

        $result = $query->groupBy('agent_id')
            ->get();

        return response()->json(['status' => true, 'data' => $result]);
    }

    public function winningReport(Request $request)
    {
        $query = Number::with([
            'ticket:id,short_name',
            'mode:id,name',
            'superAgent:id,username',
            'agent:id,username'
        ])
            ->select([
                'ticket_id',
                'mode_id',
                'super_agent_id',
                'agent_id',
                'bill_id',
                'number',
                'count',
                'prize_position',
                'winner_prize',
                'a_prize_commission'
            ])
            ->whereDate('ticket_date', '>=', $request->fromDate)
            ->whereDate('ticket_date', '<=', $request->toDate)
            ->where('winner_prize', '>', '0');

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
        if ($request->filled('agentId')) {
            $query->where('agent_id', $request->agentId);
        }
        $result = $query->orderBy('bill_id')
            ->get();

        return response()->json(['status' => true, 'data' => $result]);
    }

    public function numberReport(Request $request)
    {
        $result = $this->getNumberWiseData($request);
        return response()->json(['status' => true, 'data' => $result]);
    }

    public function numberReportPdf(Request $request)
    {
        $ticket = 'All';
        if ($request->filled('ticketId')) {
            $ticket = Ticket::where('id', $request->ticketId)->value('short_name');
        }

        $column = "yes";

        $rows = $this->getNumberWiseData($request);
        $totalCount = $rows->sum('count');
        $pdf = Pdf::loadView('report.number-wise-pdf', [
            'rows' => $rows,
            'date' => $request->resultDate,
            'ticket' => $ticket,
            'created_at' => date('Y-M-d h:i A'),
            'count' => $totalCount,
            'column' => $column
        ]);
        return $pdf->stream('number-wise-report.pdf');
    }

    public function accountSummary(Request $request)
    {

        $query = Number::with(['agent:id,username'])
            ->selectRaw('
                agent_id,
                SUM(COALESCE(winner_prize,0)) as winner_prize,
                SUM(COALESCE(a_prize_commission,0)) as agent_prize,
                SUM(COALESCE(a_rate,0)) as rate_total
                ')
            ->whereDate('ticket_date', '>=', $request->fromDate)
            ->whereDate('ticket_date', '<=', $request->toDate);

        if ($request->filled('ticketId')) {
            $query->where('ticket_id', $request->ticketId);
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

        $result = $query->groupBy('agent_id')
            ->orderByDesc('rate_total')
            ->get();
        return response()->json(['status' => true, 'data' => $result]);
    }

    public function netPay(Request $request)
    {
        $query = Number::with(['agent:id,username'])
            ->selectRaw('
                agent_id,
                SUM(COALESCE(winner_prize,0)) as winner_prize,
                SUM(COALESCE(a_prize_commission,0)) as agent_prize,
                SUM(COALESCE(sa_rate,0)) as rate_total
                ')
            ->whereDate('ticket_date', '>=', $request->fromDate)
            ->whereDate('ticket_date', '<=', $request->toDate);

        if ($request->filled('ticketId')) {
            $query->where('ticket_id', $request->ticketId);
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
        $result = $query->groupBy('agent_id')
            ->orderByDesc('rate_total')
            ->get();
        return response()->json(['status' => true, 'data' => $result]);
    }

    private function getNumberWiseData(Request $request)
    {
        $query = Number::query()
            ->join('tickets', 'tickets.id', '=', 'numbers.ticket_id')
            ->join('modes', 'modes.id', '=', 'numbers.mode_id')
            ->whereDate('numbers.ticket_date', $request->resultDate);
        // Optional filters
        if ($request->filled('ticketId')) {
            $query->where('numbers.ticket_id', $request->ticketId);
        }
        if ($request->filled('ticketNumber')) {
            $query->where('numbers.number', $request->ticketNumber);
        }
        if ($request->filled('groupId')) {
            $query->where('numbers.group_id', $request->groupId);
        }
        if ($request->filled('modeId')) {
            $query->where('numbers.mode_id', $request->modeId);
        }
        // User scope
        if ($request->filled('superAgentId')) {
            $query->where('numbers.super_agent_id', $request->superAgentId);
        }
        if ($request->filled('agentId')) {
            $query->where('numbers.agent_id', $request->agentId);
        }

        return $query->selectRaw(' tickets.short_name as ticket_name,
                            modes.name as mode_name,
                            numbers.number,
                            SUM(numbers.`count`) as count
                        ')
            ->groupBy(
                'numbers.ticket_id',
                'numbers.mode_id',
                'numbers.number',
                'tickets.short_name',
                'modes.name'
            )->orderBy('numbers.ticket_id')
            ->orderBy('numbers.mode_id')
            ->orderBy('numbers.number')
            ->get();
    }
}
