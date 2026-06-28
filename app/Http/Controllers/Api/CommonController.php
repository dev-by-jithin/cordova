<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Rate;
use App\Models\Scheme;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    public function groups(Request $request)
    {
        $groups = Group::select('id', 'name')->where('is_active', 'Yes')->get();
        return response($groups, 200);
    }

    public function agents(Request $request)
    {
        $superAgentId = $request->user()->id;
        $agents = User::with([
            'superAgent:id,username',
            'scheme:id,name'
        ])
            ->select('id', 'username', 'super_agent_id', 'scheme_id')
            ->where('is_active', 'Yes')
            ->where('role', 'Agent')
            ->where('super_agent_id', $superAgentId)
            ->get();
        return response(['agents' => $agents, 'superAgent' => ['id' => $request->user()->id, 'userName' => $request->user()->username] ], 200);
    }


    public function schemes(Request $request)
    {
        $schemes = Scheme::select('id', 'name')->where('is_active', 'Yes')->get();
        return response($schemes, 200);
    }

    public function tickets(Request $request)
    {
        $tickets = Ticket::select('id', 'name')->where('is_active', 'Yes')->get();
        return response($tickets, 200);
    }

    public function rates(Request $request)
    {
        $ticketId = $request->ticket_id;
        $agentId = $request->agent_id;
        $schemeId = User::where('id', $agentId)->value('scheme_id');
        $rates = Rate::with(['ticket:id,name', 'mode:id,name'])
                ->where('ticket_id', $ticketId)
                ->where('scheme_id', $schemeId)
                ->orderBy('mode_id', 'DESC')
                ->get();
        return response($rates, 200);
    }
}
