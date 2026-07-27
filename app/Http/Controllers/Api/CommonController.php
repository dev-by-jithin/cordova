<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Group;
use App\Models\Mode;
use App\Models\Number;
use App\Models\Price;
use App\Models\Rate;
use App\Models\Scheme;
use App\Models\Ticket;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return response($agents, 200);
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
        $role = Auth::user()->role;
        $ticketId = $request->ticket_id;

        if ($role == 'Super Agent') {
            $superAgentId = $request->user()->id;
            $agentId = $request->agent_id; // nullable
        } else {
            $superAgentId = $request->user()->super_agent_id;
            $agentId = $request->user()->id; // nullable
        }

        $rates = DB::table('rates as sr')
            ->select(
                'tickets.name as ticket_name',
                'modes.name as mode_name',

                'sr.id as super_rate_id',
                'sr.ticket_rate',
                'sr.rate as super_agent_rate',

                'ar.id as agent_rate_id',
                'ar.rate as agent_rate'
            )
            ->join('tickets', 'tickets.id', '=', 'sr.ticket_id')
            ->join('modes', 'modes.id', '=', 'sr.mode_id')

            ->leftJoin('rates as ar', function ($join) use ($agentId) {
                $join->on('ar.ticket_id', '=', 'sr.ticket_id')
                    ->on('ar.mode_id', '=', 'sr.mode_id');

                if ($agentId) {
                    $join->where('ar.user_id', '=', $agentId);
                } else {
                    $join->whereRaw('1 = 0');
                }
            })

            ->where('sr.ticket_id', $ticketId)
            ->where('sr.user_id', $superAgentId)
            ->orderBy('sr.mode_id', 'DESC')
            ->get();
        return response($rates, 200);

    }

    public function prices(Request $request)
    {
        $ticketId = $request->ticketId;

        $userId = Auth::user()->id;

        $schemeId = Auth::user()->scheme_id;

        $modes = Mode::with(['group:id,name'])->select('id', 'group_id', 'name')->orderBy('sort_order', 'DESC')->get();

        $prices = Price::where('scheme_id', $schemeId)->get();

        $priceArray = [];

        foreach ($modes as $mode) {

            if (Auth::user()->role == 'Super Agent') {
                $rate = Rate::where('ticket_id', $ticketId)
                    ->where('user_id', $userId)
                    ->where('mode_id', $mode->id)
                    ->value('rate');
            } else {
                $rate = '';
            }


            foreach ($prices as $price) {

                if ($mode->id == $price->mode_id) {

                    $priceArray[$mode->name . "@" . $mode->group->name . "@" . $rate][] = [
                        'position' => $price->position,
                        'count' => $price->count,
                        'winnerAmount' => $price->winner_amount,
                        'superAgentAmount' => $price->super_agent_amount,
                        'agentAmount' => $price->agent_amount
                    ];
                }
            }
        }

        return response(['prices' => $priceArray], 200);
    }

    public function updateAgentRate(Request $request, Rate $rate)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0'
        ]);

        $superAgentRate = $request->super_rate;

        if ($request->rate < $superAgentRate) {
            return response()->json([
                'status' => false,
                'message' => 'Agent rate must be more than Super Agent rate.'
            ], 422);
        }

        $rate->update([
            'rate' => $request->rate
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Agent rate updated successfully.'
        ]);
    }

    public function add(Request $request)
    {
        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::user()->id;
        } else {
            $agentId = $request->agentId;
        }

        $groupId = $request->groupId;
        $ticketId = $request->ticketId;
        $modeId = $request->modeId;
        $button = $request->buttonMode;
        $combination = $request->combination;
        $number = $request->number;
        $count = $request->count;
        $start = $request->start;
        $end = $request->end;
        $box = $request->box;

        $rates = Rate::select('ticket_rate', 'rate')
            ->where('ticket_id', $ticketId)
            ->where('user_id', $agentId)
            ->where('mode_id', $modeId)
            ->first();
        if ($rates) {
            $rate = $rates->rate;
            $collect = $rates->ticket_rate;
            $commission = $collect - $rate;
        }


        if ($groupId == 1) {
            $tr = '';
            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesA = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 1)
                    ->first();
                $rateA = $ratesA->rate;
                $collectA = $ratesA->ticket_rate;
                $commissionA = $collectA - $rateA;

                $ratesB = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 2)
                    ->first();
                $rateB = $ratesB->rate;
                $collectB = $ratesB->ticket_rate;
                $commissionB = $collectB - $rateB;

                $ratesC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 3)
                    ->first();
                $rateC = $ratesC->rate;
                $collectC = $ratesC->ticket_rate;
                $commissionC = $collectC - $rateC;

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateA) . '" data-collect="' . ($count * $collectA) . '" data-commission="' . ($count * $commissionA) . '">
                                    <td>' . $ticket . ' A </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateA) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="1">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateA . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateA) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectA) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionA) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateB) . '" data-collect="' . ($count * $collectB) . '" data-commission="' . ($count * $commissionB) . '">
                                    <td>' . $ticket . ' B </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="2">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionB) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateC) . '" data-collect="' . ($count * $collectC) . '" data-commission="' . ($count * $commissionC) . '">
                                    <td>' . $ticket . ' C </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="3">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionC) . '">
                                    </td>
                                </tr>';
                    }
                } else {

                    $tr = '<tr data-count="' . $count . '" data-rate="' . ($count * $rateA) . '" data-collect="' . ($count * $collectA) . '" data-commission="' . ($count * $commissionA) . '">
                                    <td>' . $ticket . ' A</td>
                                    <td>' . $number . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateA) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="1">
                                        <input type="hidden" class="number" value="' . $number . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateA . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateA) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectA) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionA) . '">
                                    </td>
                                </tr>';

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateB) . '" data-collect="' . ($count * $collectB) . '" data-commission="' . ($count * $commissionB) . '">
                                    <td>' . $ticket . ' B</td>
                                    <td>' . $number . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="2">
                                        <input type="hidden" class="number" value="' . $number . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionB) . '">
                                    </td>
                                </tr>';

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateC) . '" data-collect="' . ($count * $collectC) . '" data-commission="' . ($count * $commissionC) . '">
                                    <td>' . $ticket . ' C</td>
                                    <td>' . $number . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="3">
                                        <input type="hidden" class="number" value="' . $number . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionC) . '">
                                    </td>
                                </tr>';
                }

            } else {

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }
                } else {
                    $tr = '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $number . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $number . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                }
            }

            return response($tr);
        }

        if ($groupId == 2) {
            $tr = '';
            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesAB = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 4)
                    ->first();
                $rateAB = $ratesAB->rate;
                $collectAB = $ratesAB->ticket_rate;
                $commissionAB = $collectAB - $rateAB;

                $ratesBC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 5)
                    ->first();
                $rateBC = $ratesBC->rate;
                $collectBC = $ratesBC->ticket_rate;
                $commissionBC = $collectBC - $rateBC;

                $ratesAC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 6)
                    ->first();
                $rateAC = $ratesAC->rate;
                $collectAC = $ratesAC->ticket_rate;
                $commissionAC = $collectAC - $rateAC;

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAB) . '" data-collect="' . ($count * $collectAB) . '" data-commission="' . ($count * $commissionAB) . '">
                                    <td>' . $ticket . ' AB </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="4">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAB) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBC) . '" data-collect="' . ($count * $collectBC) . '" data-commission="' . ($count * $commissionBC) . '">
                                    <td>' . $ticket . ' BC </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="5">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBC) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAC) . '" data-collect="' . ($count * $collectAC) . '" data-commission="' . ($count * $commissionAC) . '">
                                    <td>' . $ticket . ' AC </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="6">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAC) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAB) . '" data-collect="' . ($count * $collectAB) . '" data-commission="' . ($count * $commissionAB) . '">
                                    <td>' . $ticket . ' AB</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="4">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAB) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBC) . '" data-collect="' . ($count * $collectBC) . '" data-commission="' . ($count * $commissionBC) . '">
                                    <td>' . $ticket . ' BC</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="5">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBC) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAC) . '" data-collect="' . ($count * $collectAC) . '" data-commission="' . ($count * $commissionAC) . '">
                                    <td>' . $ticket . ' AC</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="6">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAC) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '10') {

                    $digits = $this->combination10($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAB) . '" data-collect="' . ($count * $collectAB) . '" data-commission="' . ($count * $commissionAB) . '">
                                    <td>' . $ticket . ' AB</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="4">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAB) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBC) . '" data-collect="' . ($count * $collectBC) . '" data-commission="' . ($count * $commissionBC) . '">
                                    <td>' . $ticket . ' BC</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="5">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBC) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAC) . '" data-collect="' . ($count * $collectAC) . '" data-commission="' . ($count * $commissionAC) . '">
                                    <td>' . $ticket . ' AC</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="6">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAC) . '">
                                    </td>
                                </tr>';
                    }


                } elseif ($combination == '11') {

                    $digits = $this->combination11($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAB) . '" data-collect="' . ($count * $collectAB) . '" data-commission="' . ($count * $commissionAB) . '">
                                    <td>' . $ticket . ' AB</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAB) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="4">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAB . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAB) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAB) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAB) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBC) . '" data-collect="' . ($count * $collectBC) . '" data-commission="' . ($count * $commissionBC) . '">
                                    <td>' . $ticket . ' BC</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="5">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBC) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAC) . '" data-collect="' . ($count * $collectAC) . '" data-commission="' . ($count * $commissionAC) . '">
                                    <td>' . $ticket . ' AC</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateAC) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="6">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateAC . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateAC) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectAC) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionAC) . '">
                                    </td>
                                </tr>';
                    }

                } else {

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAB) . '" data-collect="' . ($count * $collectAB) . '" data-commission="' . ($count * $commissionAB) . '">
                                <td>' . $ticket . ' AB</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rateAB) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="4">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateAB . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rateAB) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collectAB) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commissionAB) . '">
                                </td>
                            </tr>';

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBC) . '" data-collect="' . ($count * $collectBC) . '" data-commission="' . ($count * $commissionBC) . '">
                                <td>' . $ticket . ' BC</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rateBC) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="5">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateBC . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rateBC) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collectBC) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commissionBC) . '">
                                </td>
                            </tr>';

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateAC) . '" data-collect="' . ($count * $collectAC) . '" data-commission="' . ($count * $commissionAC) . '">
                                <td>' . $ticket . ' AC</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rateAC) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="6">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateAC . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rateAC) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collectAC) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commissionAC) . '">
                                </td>
                            </tr>';
                }

            } else {

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '10') {

                    $digits = $this->combination10($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '11') {

                    $digits = $this->combination11($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } else {

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                <td>' . $button . '</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rate) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="' . $modeId . '">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rate . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                </td>
                            </tr>';
                }
            }

            return response($tr);
        }

        if ($groupId == 3) {
            $tr = '';
            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesSuper = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 8)
                    ->first();
                $rateSuper = $ratesSuper->rate;
                $collectSuper = $ratesSuper->ticket_rate;
                $commissionSuper = $collectSuper - $rateSuper;

                $ratesBox = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 7)
                    ->first();
                $rateBox = $ratesBox->rate;
                $collectBox = $ratesBox->ticket_rate;
                $commissionBox = $collectBox - $rateBox;

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateSuper) . '" data-collect="' . ($count * $collectSuper) . '" data-commission="' . ($count * $commissionSuper) . '">
                                    <td>' . $ticket . ' SUPER </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateSuper) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="8">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateSuper . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateSuper) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectSuper) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionSuper) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBox) . '" data-collect="' . ($count * $collectBox) . '" data-commission="' . ($count * $commissionBox) . '">
                                    <td>' . $ticket . ' BOX </td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBox) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="7">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBox) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBox) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBox) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateSuper) . '" data-collect="' . ($count * $collectSuper) . '" data-commission="' . ($count * $commissionSuper) . '">
                                    <td>' . $ticket . ' SUPER</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateSuper) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="8">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateSuper . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateSuper) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectSuper) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionSuper) . '">
                                    </td>
                                </tr>';
                    }

                    if (isset($box)) {
                        for ($i = 0; $i < count($collections); $i++) {

                            $tr .= '<tr data-count="' . $box . '" data-rate="' . ($box * $rateBox) . '" data-collect="' . ($box * $collectBox) . '" data-commission="' . ($box * $commissionBox) . '">
                                        <td>' . $ticket . ' BOX</td>
                                        <td>' . $collections[$i] . '</td>
                                        <td>' . $box . '</td>
                                        <td>' . ($box * $rateBox) . '</td>
                                        <td>
                                            <i class="bi bi-trash-fill text-danger delete-row"></i>
                                            <input type="hidden" class="group_id" value="' . $groupId . '">
                                            <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                            <input type="hidden" class="mode_id" value="7">
                                            <input type="hidden" class="number" value="' . $collections[$i] . '">
                                            <input type="hidden" class="count" value="' . $box . '">
                                            <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                            <input type="hidden" class="rate" value="' . ($box * $rateBox) . '">
                                            <input type="hidden" class="collection" value="' . ($box * $collectBox) . '">
                                            <input type="hidden" class="commission" value="' . ($box * $commissionBox) . '">
                                        </td>
                                    </tr>';
                        }
                    } else {

                        for ($i = 0; $i < count($collections); $i++) {

                            $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBox) . '" data-collect="' . ($count * $collectBox) . '" data-commission="' . ($count * $commissionBox) . '">
                                        <td>' . $ticket . ' BOX</td>
                                        <td>' . $collections[$i] . '</td>
                                        <td>' . $count . '</td>
                                        <td>' . ($count * $rateBox) . '</td>
                                        <td>
                                            <i class="bi bi-trash-fill text-danger delete-row"></i>
                                            <input type="hidden" class="group_id" value="' . $groupId . '">
                                            <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                            <input type="hidden" class="mode_id" value="7">
                                            <input type="hidden" class="number" value="' . $collections[$i] . '">
                                            <input type="hidden" class="count" value="' . $count . '">
                                            <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                            <input type="hidden" class="rate" value="' . ($count * $rateBox) . '">
                                            <input type="hidden" class="collection" value="' . ($count * $collectBox) . '">
                                            <input type="hidden" class="commission" value="' . ($count * $commissionBox) . '">
                                        </td>
                                    </tr>';
                        }
                    }



                } elseif ($combination == '100') {

                    $digits = $this->combination100($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateSuper) . '" data-collect="' . ($count * $collectSuper) . '" data-commission="' . ($count * $commissionSuper) . '">
                                    <td>' . $ticket . ' SUPER</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateSuper) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="8">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateSuper . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateSuper) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectSuper) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionSuper) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBox) . '" data-collect="' . ($count * $collectBox) . '" data-commission="' . ($count * $commissionBox) . '">
                                    <td>' . $ticket . ' BOX</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBox) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="7">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBox) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBox) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBox) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '111') {

                    $digits = $this->combination111($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateSuper) . '" data-collect="' . ($count * $collectSuper) . '" data-commission="' . ($count * $commissionSuper) . '">
                                    <td>' . $ticket . ' SUPER</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateSuper) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="8">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateSuper . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateSuper) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectSuper) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionSuper) . '">
                                    </td>
                                </tr>';
                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBox) . '" data-collect="' . ($count * $collectBox) . '" data-commission="' . ($count * $commissionBox) . '">
                                    <td>' . $ticket . ' BOX</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rateBox) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="7">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rateBox) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collectBox) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commissionBox) . '">
                                    </td>
                                </tr>';
                    }

                } else {

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateSuper) . '" data-collect="' . ($count * $collectSuper) . '" data-commission="' . ($count * $commissionSuper) . '">
                                <td>' . $ticket . ' SUPER</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rateSuper) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="8">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateSuper . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rateSuper) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collectSuper) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commissionSuper) . '">
                                </td>
                            </tr>';

                    if (isset($box)) {
                        $tr .= '<tr data-count="' . $box . '" data-rate="' . ($box * $rateBox) . '" data-collect="' . ($box * $collectBox) . '" data-commission="' . ($box * $commissionBox) . '">
                                <td>' . $ticket . ' BOX</td>
                                <td>' . $number . '</td>
                                <td>' . $box . '</td>
                                <td>' . ($box * $rateBox) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="7">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $box . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                    <input type="hidden" class="rate" value="' . ($box * $rateBox) . '">
                                    <input type="hidden" class="collection" value="' . ($box * $collectBox) . '">
                                    <input type="hidden" class="commission" value="' . ($box * $commissionBox) . '">
                                </td>
                            </tr>';
                    } else {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rateBox) . '" data-collect="' . ($count * $collectBox) . '" data-commission="' . ($count * $commissionBox) . '">
                                <td>' . $ticket . ' BOX</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rateBox) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="7">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rateBox . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rateBox) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collectBox) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commissionBox) . '">
                                </td>
                            </tr>';
                    }
                }

            } else {

                if ($combination === 'range') {

                    for ($i = $start; $i <= $end; $i++) {
                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $i . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $i . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $collections[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $collections[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '100') {

                    $digits = $this->combination100($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } elseif ($combination == '111') {

                    $digits = $this->combination111($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                    <td>' . $button . '</td>
                                    <td>' . $digits[$i] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . ($count * $rate) . '</td>
                                    <td>
                                        <i class="bi bi-trash-fill text-danger delete-row"></i>
                                        <input type="hidden" class="group_id" value="' . $groupId . '">
                                        <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                        <input type="hidden" class="mode_id" value="' . $modeId . '">
                                        <input type="hidden" class="number" value="' . $digits[$i] . '">
                                        <input type="hidden" class="count" value="' . $count . '">
                                        <input type="hidden" class="agent_rate" value="' . $rate . '">
                                        <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                        <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                        <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                    </td>
                                </tr>';
                    }

                } else {

                    $tr .= '<tr data-count="' . $count . '" data-rate="' . ($count * $rate) . '" data-collect="' . ($count * $collect) . '" data-commission="' . ($count * $commission) . '">
                                <td>' . $button . '</td>
                                <td>' . $number . '</td>
                                <td>' . $count . '</td>
                                <td>' . ($count * $rate) . '</td>
                                <td>
                                    <i class="bi bi-trash-fill text-danger delete-row"></i>
                                    <input type="hidden" class="group_id" value="' . $groupId . '">
                                    <input type="hidden" class="ticket_id" value="' . $ticketId . '">
                                    <input type="hidden" class="mode_id" value="' . $modeId . '">
                                    <input type="hidden" class="number" value="' . $number . '">
                                    <input type="hidden" class="count" value="' . $count . '">
                                    <input type="hidden" class="agent_rate" value="' . $rate . '">
                                    <input type="hidden" class="rate" value="' . ($count * $rate) . '">
                                    <input type="hidden" class="collection" value="' . ($count * $collect) . '">
                                    <input type="hidden" class="commission" value="' . ($count * $commission) . '">
                                </td>
                            </tr>';
                }
            }

            return response($tr);
        }

    }

    public function saveNumber(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'numbers' => 'required|array|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticketId);
        $currentTime = Carbon::now()->format('H:i:s');
        $closeTime = Carbon::parse($ticket->result_time)->format('H:i:s');

        if ($currentTime >= $closeTime) {
            return response([
                'status' => false,
                'message' => 'Ticket window closed.'
            ], 422);
        }

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
            $superAgentId = Auth::user()->super_agent_id;
        } else {
            $agentId = $request->agentId;
            $superAgentId = Auth::id();
        }



        try {

            $bill = DB::transaction(function () use ($request, $agentId, $superAgentId) {

                $bill = Bill::create([
                    'super_agent_id' => $superAgentId,
                    'agent_id'       => $agentId,
                    'ticket_id' => $request->ticketId
                ]);

                $now = now();

                $numbers = collect($request->numbers)
                    ->map(function ($row) use ($bill, $agentId, $superAgentId, $now) {

                        return [
                            'bill_id'          => $bill->id,
                            'super_agent_id'   => $superAgentId,
                            'agent_id'         => $agentId,
                            'group_id'         => $row['group_id'],
                            'ticket_id'        => $row['ticket_id'],
                            'mode_id'          => $row['mode_id'],
                            'number'           => $row['number'],
                            'count'            => $row['count'],
                            'agent_rate'       => $row['agent_rate'],
                            'rate'             => $row['rate'],
                            'collection'       => $row['collection'],
                            'commission'       => $row['commission'],
                            'created_at'       => $now,
                            'updated_at'       => $now,
                        ];
                    })
                    ->toArray();

                Number::insert($numbers);

                return $bill;

            });

            return response()->json([
                'status' => true,
                'bill' => $bill->id,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteNumber(Request $request)
    {
        $billId = $request->billId;
        $numberId = $request->numberId;

        $bill = Bill::with(['ticket:id,result_time'])->find($billId);

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
            $superAgentId = Auth::user()->super_agent_id;
        } else {
            $agentId = $request->agentId;
            $superAgentId = Auth::id();
        }

        $currentTime = now()->format('H:i:s');
        $closeTime = Carbon::parse($bill->ticket->result_time)->format('H:i:s');

        if(now()->isSameDay($bill->created_at) && $currentTime < $closeTime)
        {
            try {
                Number::where('agent_id', $agentId)
                ->where('id', $numberId)
                ->delete();
                return response([
                    'status' => true
                ]);
            } catch (\Throwable $th) {
                return response([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }

        }else{
            return response([
                'status' => false,
                'message' => 'Bill locked'
            ]);
        }
    }

    public function deleteBill(Request $request)
    {

        $billId = $request->billId;
        $bill = Bill::with(['ticket:id,result_time'])->find($billId);

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
            $superAgentId = Auth::user()->super_agent_id;
        } else {
            $agentId = $request->agentId;
            $superAgentId = Auth::id();
        }

        $currentTime = now()->format('H:i:s');
        $closeTime = Carbon::parse($bill->ticket->result_time)->format('H:i:s');

        if(now()->isSameDay($bill->created_at) && $currentTime < $closeTime)
        {
            try {
                Bill::where('agent_id', $agentId)
                ->where('id', $billId)
                ->delete();
                return response([
                    'status' => true
                ]);
            } catch (\Throwable $th) {
                return response([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }

        }else{
            return response([
                'status' => false,
                'message' => 'Bill locked'
            ]);
        }
    }

    public function billDetails(Request $request)
    {
        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::user()->id;
            $numbers = Number::with(['ticket:id,short_name', 'mode:id,name'])
            ->where('agent_id', $agentId)
            ->where('bill_id', $request->billId)
            ->get();
        } else {
            $superAgentId = Auth::user()->id;
            $numbers = Number::with(['ticket:id,short_name', 'mode:id,name'])
            ->where('super_agent_id', $superAgentId)
            ->where('bill_id', $request->billId)
            ->get();
        }

        $bill = Bill::with(['ticket:id,result_time',])->find($request->billId);

        if(count($numbers) > 0){

            $currentTime = now()->format('H:i:s');
            $closeTime = Carbon::parse($bill->ticket->result_time)->format('H:i:s');

            if(date('Y-m-d') == date('Y-m-d', strtotime($bill->created_at)) && $currentTime < $closeTime)
            {
                $deleteBtn = true;
                $deleteBillBtn = '<button data-bill-id="'.$bill->id.'" class="btn btn-sm btn-danger w-100" id="delete-bill-btn">
                                    <i class="bi bi-trash-fill pe-1"></i> Delete Bill</button>';

            }else{
                $deleteBtn = null;
                $deleteBillBtn = null;
            }

            $tr = '';

            foreach($numbers as $number) {

                if(isset($deleteBtn)){
                    $delete = '<i data-number-id="'.$number->id.'" class="bi bi-pencil-fill text-danger edit-row"></i>
                                <i data-number-id="'.$number->id.'" data-bill-id="'.$bill->id.'" class="bi bi-trash-fill text-danger delete-row"></i>';
                }else{
                    $delete = '';
                }

                $tr .= '<tr id="row-'.$number->id.'" data-count="' . $number->count . '" data-rate="' . $number->rate . '" data-collect="' . $number->collection . '" data-commission="' . $number->commission . '">
                            <td class="ticket-name">' . $number->ticket->short_name . ' &nbsp;' . $number->mode->name . '</td>
                            <td>' . $number->number . '</td>
                            <td>' . $number->count . '</td>
                            <td>' . $number->rate . '</td>
                            <td>
                                '.$delete.'
                                <input type="hidden" class="group_id" value="' . $number->group_id . '">
                                <input type="hidden" class="ticket_id" value="' . $number->ticket_id . '">
                                <input type="hidden" class="mode_id" value="'. $number->mode_id .'">
                                <input type="hidden" class="number" value="' . $number->number . '">
                                <input type="hidden" class="count" value="' . $number->count . '">
                                <input type="hidden" class="rate" value="' . ($number->rate) . '">
                                <input type="hidden" class="collection" value="' . ($number->collection) . '">
                                <input type="hidden" class="commission" value="' . ($number->commission) . '">
                            </td>
                        </tr>';
            }
            $ticket = $bill->ticket->result_time;
            return response([
                'status' => true,
                'tr' => $tr,
                'bill' => $bill->id,
                'result' => date('Y-M-d', strtotime($numbers[0]['created_at'])) . ' ' . date('h:i A', strtotime($ticket)),
                'created_at' => date('Y-M-d h:i A', strtotime($numbers[0]['created_at'])),
                'delete_bill' => $deleteBillBtn
            ]);

        }else{
            return response([
                'status' => false,
                'message' => 'Unauthorized!'
            ]);
        }

    }

    function permutations($string)
    {
        if (strlen($string) <= 1) {
            return [$string];
        }

        $result = [];

        for ($i = 0; $i < strlen($string); $i++) {

            $char = $string[$i];
            $remaining = substr($string, 0, $i) . substr($string, $i + 1);

            foreach ($this->permutations($remaining) as $perm) {
                $result[] = $char . $perm;
            }
        }

        return array_values(array_unique($result));
    }

    function combination10($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 10) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    function combination100($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 100) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    function combination11($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 11) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    function combination111($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 111) {
            $numbers[] = $i;
        }

        return $numbers;
    }
}
