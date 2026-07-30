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
            $collection = $rates->ticket_rate;
            $commission = $collection - $rate;
        }

        if ($groupId == 1) {

            $rows = [];

            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesA = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 1)
                    ->first();
                $rateA = $ratesA->rate;
                $collectionA = $ratesA->ticket_rate;
                $commissionA = $collectionA - $rateA;

                $ratesB = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 2)
                    ->first();
                $rateB = $ratesB->rate;
                $collectionB = $ratesB->ticket_rate;
                $commissionB = $collectionB - $rateB;

                $ratesC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 3)
                    ->first();
                $rateC = $ratesC->rate;
                $collectionC = $ratesC->ticket_rate;
                $commissionC = $collectionC - $rateC;

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' A', $number, $count, $groupId, 1, $rateA, $collectionA, $commissionA);

                    }

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' B', $number, $count, $groupId, 2, $rateB, $collectionB, $commissionB);

                    }

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' C', $number, $count, $groupId, 3, $rateC, $collectionC, $commissionC);

                    }

                } else {

                    $rows[] = $this->makeRow($ticket . ' A', $number, $count, $groupId, 1, $rateA, $collectionA, $commissionA);
                    $rows[] = $this->makeRow($ticket . ' B', $number, $count, $groupId, 2, $rateB, $collectionB, $commissionB);
                    $rows[] = $this->makeRow($ticket . ' C', $number, $count, $groupId, 3, $rateC, $collectionC, $commissionC);

                }

            } else {

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                    }
                } else {

                    $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                }
            }

            return response()->json(['status' => true, 'rows' => $rows]);
        }

        if ($groupId == 2) {

            $rows = [];

            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesAB = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 4)
                    ->first();
                $rateAB = $ratesAB->rate;
                $collectionAB = $ratesAB->ticket_rate;
                $commissionAB = $collectionAB - $rateAB;

                $ratesBC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 5)
                    ->first();
                $rateBC = $ratesBC->rate;
                $collectionBC = $ratesBC->ticket_rate;
                $commissionBC = $collectionBC - $rateBC;

                $ratesAC = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 6)
                    ->first();
                $rateAC = $ratesAC->rate;
                $collectionAC = $ratesAC->ticket_rate;
                $commissionAC = $collectionAC - $rateAC;

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' AB', $number, $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);

                    }

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' BC', $number, $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);

                    }

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' AC', $number, $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AB', $collections[$i], $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);

                    }

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($ticket . ' BC', $collections[$i], $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);

                    }

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AC', $collections[$i], $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

                    }

                } elseif ($combination == '10') {

                    $digits = $this->combination10($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AB', $digits[$i], $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' BC', $digits[$i], $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AC', $digits[$i], $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

                    }


                } elseif ($combination == '11') {

                    $digits = $this->combination11($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AB', $digits[$i], $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' BC', $digits[$i], $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' AC', $digits[$i], $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

                    }

                } else {

                    $rows[] = $this->makeRow($ticket . ' AB', $number, $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);
                    $rows[] = $this->makeRow($ticket . ' BC', $number, $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);
                    $rows[] = $this->makeRow($ticket . ' AC', $number, $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

                }

            } else {

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($button, $collections[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == '10') {

                    $digits = $this->combination10($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($button, $digits[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == '11') {

                    $digits = $this->combination11($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($button, $digits[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } else {

                    $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                }
            }

            return response()->json(['status' => true, 'rows' => $rows]);
        }

        if ($groupId == 3) {

            $rows = [];

            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesSuper = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 8)
                    ->first();
                $rateSuper = $ratesSuper->rate;
                $collectionSuper = $ratesSuper->ticket_rate;
                $commissionSuper = $collectionSuper - $rateSuper;

                $ratesBox = Rate::select('ticket_rate', 'rate')
                    ->where('ticket_id', $ticketId)
                    ->where('user_id', $agentId)
                    ->where('mode_id', 7)
                    ->first();
                $rateBox = $ratesBox->rate;
                $collectionBox = $ratesBox->ticket_rate;
                $commissionBox = $collectionBox - $rateBox;

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' SUPER', $number, $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    }

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($ticket . ' BOX', $number, $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($ticket . ' SUPER', $collections[$i], $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    }

                    if (isset($box)) {

                        for ($i = 0; $i < count($collections); $i++) {

                            $rows[] = $this->makeRow($ticket . ' BOX', $collections[$i], $box, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                        }
                    } else {

                        for ($i = 0; $i < count($collections); $i++) {

                            $rows[] = $this->makeRow($ticket . ' BOX', $collections[$i], $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                        }
                    }



                } elseif ($combination == '100') {

                    $digits = $this->combination100($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' SUPER', $digits[$i], $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' BOX', $digits[$i], $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                    }

                } elseif ($combination == '111') {

                    $digits = $this->combination111($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' SUPER', $digits[$i], $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    }

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($ticket . ' BOX', $digits[$i], $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                    }

                } else {

                    $rows[] = $this->makeRow($ticket . ' SUPER', $number, $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    if (isset($box)) {

                        $rows[] = $this->makeRow($ticket . ' BOX', $number, $box, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                    } else {

                        $rows[] = $this->makeRow($ticket . ' BOX', $number, $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

                    }
                }

            } else {

                if ($combination === 'range') {

                    for ($number = $start; $number <= $end; $number++) {

                        $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == 'set') {

                    $collections = $this->permutations($number);

                    for ($i = 0; $i < count($collections); $i++) {

                        $rows[] = $this->makeRow($button, $collections[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == '100') {

                    $digits = $this->combination100($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($button, $digits[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } elseif ($combination == '111') {

                    $digits = $this->combination111($start, $end);

                    for ($i = 0; $i < count($digits); $i++) {

                        $rows[] = $this->makeRow($button, $digits[$i], $count, $groupId, $modeId, $rate, $collection, $commission);

                    }

                } else {

                    $rows[] = $this->makeRow($button, $number, $count, $groupId, $modeId, $rate, $collection, $commission);

                }
            }

            return response()->json(['status' => true, 'rows' => $rows]);
        }
    }

    public function saveNumber(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'numbers' => 'required|array|min:1',
            'numbers.*.group_id' => 'required|exists:groups,id',
            'numbers.*.mode_id' => 'required|exists:modes,id',
            'numbers.*.number' => 'required|string|max:3',
            'numbers.*.count' => 'required|integer|min:1|max:1000'
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
                    'agent_id' => $agentId,
                    'ticket_id' => $request->ticketId
                ]);

                $now = now();
                $ticketId = $request->ticketId;

                $numbers = collect($request->numbers)
                    ->map(function ($row) use ($ticketId, $bill, $agentId, $superAgentId, $now) {

                        $aRate = Rate::select('ticket_rate', 'rate')
                            ->where('ticket_id', $ticketId)
                            ->where('user_id', $agentId)
                            ->where('mode_id', $row['mode_id'])
                            ->first();
                        $saRate = Rate::select('rate')
                            ->where('ticket_id', $ticketId)
                            ->where('user_id', $superAgentId)
                            ->where('mode_id', $row['mode_id'])
                            ->first();
                        if (strlen($row['number']) == $row['group_id']) {

                            return [
                                'bill_id' => $bill->id,
                                'super_agent_id' => $superAgentId,
                                'agent_id' => $agentId,
                                'group_id' => $row['group_id'],
                                'ticket_id' => $ticketId,
                                'mode_id' => $row['mode_id'],
                                'number' => $row['number'],
                                'count' => $row['count'],
                                'collection' => $aRate->ticket_rate,
                                'collection_total' => ($aRate->ticket_rate * $row['count']),
                                'a_rate' => $aRate->rate,
                                'a_rate_total' => ($aRate->rate * $row['count']),
                                'a_commission' => ($aRate->ticket_rate - $aRate->rate),
                                'a_commission_total' => ($aRate->ticket_rate - $aRate->rate) * $row['count'],
                                'sa_rate' => $saRate->rate,
                                'sa_rate_total' => ($saRate->rate * $row['count']),
                                'sa_commission' => ($aRate->rate - $saRate->rate),
                                'sa_commission_total' => ($aRate->rate - $saRate->rate) * $row['count'],
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
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

    public function updateNumber(Request $request)
    {
        $request->validate([
            'billId' => 'required|exists:bills,id',
            'numberId' => 'required|exists:numbers,id',
            'count' => 'required|integer|min:1|max:1000',
        ]);

        $count = (int) $request->count;

        // Load bill with ownership check
        if (Auth::user()->role == 'Agent') {
            $bill = Bill::with('ticket:id,result_time')
                ->where('agent_id', Auth::id())
                ->find($request->billId);
        } else {
            $bill = Bill::with('ticket:id,result_time')
                ->where('super_agent_id', Auth::id())
                ->find($request->billId);
        }

        if (!$bill) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
        }

        // Lock check
        if ($this->isBillLocked($bill)) {
            return response()->json(['status' => false, 'message' => 'Bill locked'], 422);
        }

        try {
            $number = Number::where('bill_id', $bill->id)
                ->where('id', $request->numberId)
                ->firstOrFail();

            $number->update([
                'count' => $count,
                'collection_total' => $number->collection * $count,
                'a_rate_total' => $number->a_rate * $count,
                'a_commission_total' => $number->a_commission * $count,
                'sa_rate_total' => $number->sa_rate * $count,
                'sa_commission_total' => $number->sa_commission * $count,
            ]);
            return response()->json(['status' => true]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteNumber(Request $request)
    {
        $bill = Bill::findOrFail($request->billId);
        // ownership check
        if (Auth::user()->role == 'Agent') {
            if ($bill->agent_id != Auth::id()) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            if ($bill->super_agent_id != Auth::id()) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
        }
        // lock check
        if ($this->isBillLocked($bill)) {
            return response()->json(['status' => false, 'message' => 'Bill locked'], 422);
        }

        try {
            $deleted = Number::where('bill_id', $bill->id)
                ->where('id', $request->numberId)
                ->delete();

            $message = "Number deleted.";

            // delete bill automatically if no numbers left
            if (!$bill->numbers()->exists()) {
                $bill->delete();
                $message = "Bill deleted.";
            }

            return response()->json(['status' => $deleted > 0, 'message' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteBill(Request $request)
    {
        $bill = Bill::findOrFail($request->billId);
        // ownership check
        if (Auth::user()->role == 'Agent') {
            if ($bill->agent_id != Auth::id()) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            if ($bill->super_agent_id != Auth::id()) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
        }
        // lock check
        if ($this->isBillLocked($bill)) {
            return response()->json(['status' => false, 'message' => 'Bill locked'], 422);
        }
        try {
            $bill->delete();
            return response()->json(['status' => true]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
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

        if (count($numbers) > 0) {

            $currentTime = now()->format('H:i:s');
            $closeTime = Carbon::parse($bill->ticket->result_time)->format('H:i:s');

            if (date('Y-m-d') == date('Y-m-d', strtotime($bill->created_at)) && $currentTime < $closeTime) {
                $deleteButtons = true;
            } else {
                $deleteButtons = false;
            }

            $rows = [];

            foreach ($numbers as $number) {
                $rows[] = [
                    'ticket' => $number->ticket->short_name . ' ' . $number->mode->name,
                    'number' => $number->number,
                    'number_id' => $number->id,
                    'count' => $number->count,
                    'rate' => $number->a_rate_total,
                    'collection' => $number->collection_total,
                    'commission' => $number->a_commission_total
                ];
            }

            return response([
                'status' => true,
                'rows' => $rows,
                'bill_id' => $bill->id,
                'result' => date('Y-M-d', strtotime($bill->created_at)) . ' ' . date('h:i A', strtotime($bill->ticket->result_time)),
                'created_at' => date('Y-M-d h:i A', strtotime($bill->created_at)),
                'delete_button' => $deleteButtons
            ]);

        } else {
            return response([
                'status' => false,
                'message' => 'Unauthorized!'
            ]);
        }

    }

    private function isBillLocked(Bill $bill): bool
    {
        return !(now()->isSameDay($bill->created_at) && now()->format('H:i:s') < $bill->ticket->result_time);
    }

    private function makeRow($ticket, $number, $count, $groupId, $modeId, $rate, $collection, $commission)
    {
        return [
            'ticket_name' => $ticket,
            'number' => (string) $number,
            'count' => (int) $count,
            'group_id' => $groupId,
            'mode_id' => $modeId,
            'rate' => round($rate * $count, 2),
            'collection' => round($collection * $count, 2),
            'commission' => round($commission * $count, 2),
        ];
    }

    private function permutations($string)
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

    private function combination10($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 10) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    private function combination100($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 100) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    private function combination11($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 11) {
            $numbers[] = $i;
        }

        return $numbers;
    }

    private function combination111($start, $end)
    {
        $numbers = [];

        for ($i = $start; $i <= $end; $i += 111) {
            $numbers[] = $i;
        }

        return $numbers;
    }
}
