<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Mode;
use App\Models\Price;
use App\Models\Rate;
use App\Models\Scheme;
use App\Models\Ticket;
use App\Models\User;
use Auth;
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
            ->where('role', 'Agent')
            ->where('super_agent_id', $superAgentId)
            ->get();
        return response(['agents' => $agents, 'superAgent' => ['id' => $request->user()->id, 'userName' => $request->user()->username]], 200);
    }

    public function agent(Request $request)
    {
        $agent = User::with([
            'superAgent:id,username',
            'scheme:id,name'
        ])
            ->select(
                'id',
                'username',
                'decrypted',
                'super_agent_id',
                'scheme_id',
                'login_status',
                'sale_status',
                'role'
            )
            ->find($request->userId);

        $schemes = Scheme::select('id', 'name')->where('is_active', 'Yes')->get();
        return response(['agent' => $agent, 'schemes' => $schemes], 200);
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
        $user = User::find($agentId);


        $rates = Rate::with(['ticket:id,name', 'mode:id,name'])
            ->where('ticket_id', $ticketId)
            ->where('scheme_id', $user->scheme_id)
            ->orderBy('mode_id', 'DESC')
            ->get();
        return response(['rates' => $rates, 'role' => $user->role], 200);
    }

    public function prices(Request $request)
    {
        $schemeId = Auth::user()->scheme_id;

        $modes = Mode::with(['group:id,name'])->select('id', 'group_id', 'name')->orderBy('sort_order', 'DESC')->get();

        $prices = Price::where('scheme_id', $schemeId)->get();

        $priceArray = [];

        foreach ($modes as $mode) {

            foreach ($prices as $price) {

                if ($mode->id == $price->mode_id) {

                    $priceArray[$mode->name . "@" . $mode->group->name . "@" . 7.1][] = [
                        'position' => $price->position,
                        'count' => $price->count,
                        'winnerAmount' => $price->winner_amount,
                        'superAgentAmount' => $price->super_agent_amount,
                        'agentAmount' => $price->agent_amount
                    ];
                }
            }
        }

        return response([
            'prices' => $priceArray
        ]);
    }
}
