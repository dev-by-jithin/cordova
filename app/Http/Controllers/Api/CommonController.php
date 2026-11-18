<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Group;
use App\Models\Mode;
use App\Models\Number;
use App\Models\Prize;
use App\Models\Rate;
use App\Models\Result;
use App\Models\Ticket;
use App\Models\User;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{
    public function groups(Request $request)
    {
        $groups = Group::select('id', 'name')->where('is_active', 'Yes')->get();
        return response($groups, 200);
    }

    public function agents(Request $request)
    {
        $superAgentId = Auth::id();
        $agents = User::with([
            'superAgent:id,username'
        ])
            ->select('id', 'username', 'super_agent_id')
            ->where('role', 'Agent')
            ->where('super_agent_id', $superAgentId)
            ->get();
        return response($agents, 200);
    }

    public function agent(Request $request)
    {
        $agent = User::with([
            'superAgent:id,username'
        ])
            ->select(
                'id',
                'username',
                'decrypted',
                'super_agent_id',
                'login_status',
                'sale_status',
                'role'
            )
            ->find($request->userId);
        return response(['agent' => $agent], 200);
    }

    public function tickets(Request $request)
    {
        $tickets = Ticket::select('id', 'name')->where('is_active', 'Yes')->get();
        return response($tickets, 200);
    }

    public function rates(Request $request)
    {
        $role = Auth::user()->role;

        if ($role == 'Super Agent') {
            $superAgentId = $request->user()->id;
            $agentId = $request->agent_id; // nullable
        } else {
            $superAgentId = $request->user()->super_agent_id;
            $agentId = $request->user()->id; // nullable
        }

        $rates = DB::table('rates as sr')
            ->select(
                'modes.name as mode_name',

                'sr.id as super_rate_id',
                'sr.ticket_rate',
                'sr.user_rate as super_agent_rate',

                'ar.id as agent_rate_id',
                'ar.user_rate as agent_rate'
            )

            ->join('modes', 'modes.id', '=', 'sr.mode_id')

            ->leftJoin('rates as ar', function ($join) use ($agentId) {
                $join->on('ar.mode_id', '=', 'sr.mode_id');

                if ($agentId) {
                    $join->where('ar.user_id', '=', $agentId);
                } else {
                    $join->whereRaw('1 = 0');
                }
            })
            ->where('sr.user_id', $superAgentId)
            ->orderBy('sr.mode_id', 'DESC')
            ->get();
        return response($rates, 200);

    }

    public function prizes(Request $request)
    {
        $ticketId = $request->ticketId;

        $userId = Auth::user()->id;

        $modes = Mode::with(['group:id,name'])->select('id', 'group_id', 'name')->orderBy('sort_order', 'DESC')->get();

        $prizes = Prize::get();

        $prizeArray = [];

        foreach ($modes as $mode) {

            if (Auth::user()->role == 'Super Agent') {
                $rate = Rate::where('user_id', $userId)
                    ->where('mode_id', $mode->id)
                    ->value('user_rate');
            } else {
                $rate = '';
            }


            foreach ($prizes as $prize) {

                if ($mode->id == $prize->mode_id) {

                    $prizeArray[$mode->name . "@" . $mode->group->name . "@" . $rate][] = [
                        'position' => $prize->position,
                        'count' => $prize->count,
                        'winnerAmount' => $prize->prize,
                        'agentAmount' => $prize->agent_commission
                    ];
                }
            }
        }

        return response(['prices' => $prizeArray], 200);
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


        // $rate->update([
        //     'user_rate' => $request->rate
        // ]);

        $rate->user_rate = $request->rate;
        $rate->save();

        return response()->json([
            'status' => true,
            'message' => 'Agent rate updated successfully.'
        ]);
    }

    public function add(Request $request)
    {
        $agentId = Auth::user()->id;
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

        $rates = Rate::select('ticket_rate', 'user_rate')
            ->where('user_id', $agentId)
            ->where('mode_id', $modeId)
            ->first();
        if ($rates) {
            $rate = $rates->user_rate;
            $collection = $rates->ticket_rate;
            $commission = $collection - $rate;
        }

        if ($groupId == 1) {

            $rows = [];

            if ($modeId == 'all') {

                $ticket = Ticket::where('id', $ticketId)->value('short_name');
                $ratesA = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 1)
                    ->first();
                $rateA = $ratesA->user_rate;
                $collectionA = $ratesA->ticket_rate;
                $commissionA = $collectionA - $rateA;

                $ratesB = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 2)
                    ->first();
                $rateB = $ratesB->user_rate;
                $collectionB = $ratesB->ticket_rate;
                $commissionB = $collectionB - $rateB;

                $ratesC = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 3)
                    ->first();
                $rateC = $ratesC->user_rate;
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
                $ratesAB = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 4)
                    ->first();
                $rateAB = $ratesAB->user_rate;
                $collectionAB = $ratesAB->ticket_rate;
                $commissionAB = $collectionAB - $rateAB;

                $ratesBC = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 5)
                    ->first();
                $rateBC = $ratesBC->user_rate;
                $collectionBC = $ratesBC->ticket_rate;
                $commissionBC = $collectionBC - $rateBC;

                $ratesAC = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 6)
                    ->first();
                $rateAC = $ratesAC->user_rate;
                $collectionAC = $ratesAC->ticket_rate;
                $commissionAC = $collectionAC - $rateAC;

                if ($combination === 'range') {

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($ticket . ' AB', $formattedNumber, $count, $groupId, 4, $rateAB, $collectionAB, $commissionAB);

                    }

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($ticket . ' BC', $formattedNumber, $count, $groupId, 5, $rateBC, $collectionBC, $commissionBC);

                    }

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($ticket . ' AC', $formattedNumber, $count, $groupId, 6, $rateAC, $collectionAC, $commissionAC);

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

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($button, $formattedNumber, $count, $groupId, $modeId, $rate, $collection, $commission);

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
                $ratesSuper = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 8)
                    ->first();
                $rateSuper = $ratesSuper->user_rate;
                $collectionSuper = $ratesSuper->ticket_rate;
                $commissionSuper = $collectionSuper - $rateSuper;

                $ratesBox = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $agentId)
                    ->where('mode_id', 7)
                    ->first();
                $rateBox = $ratesBox->user_rate;
                $collectionBox = $ratesBox->ticket_rate;
                $commissionBox = $collectionBox - $rateBox;

                if ($combination === 'range') {

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($ticket . ' SUPER', $formattedNumber, $count, $groupId, 8, $rateSuper, $collectionSuper, $commissionSuper);

                    }

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($ticket . ' BOX', $formattedNumber, $count, $groupId, 7, $rateBox, $collectionBox, $commissionBox);

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

                    for ($number = (int) $start; $number <= (int) $end; $number++) {

                        $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

                        $rows[] = $this->makeRow($button, $formattedNumber, $count, $groupId, $modeId, $rate, $collection, $commission);

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

    // public function saveNumber(Request $request)
    // {
    //     if (Auth::user()->login_status == 'Active' && Auth::user()->sale_status == 'Active') {

    //         $request->validate([
    //             'ticketId' => 'required|exists:tickets,id',
    //             'numbers' => 'required|array|min:1',
    //             'numbers.*.group_id' => 'required|exists:groups,id',
    //             'numbers.*.mode_id' => 'required|exists:modes,id',
    //             'numbers.*.number' => 'required|string|max:3',
    //             'numbers.*.count' => 'required|integer|min:1|max:1000'
    //         ]);

    //         $ticket = Ticket::findOrFail($request->ticketId);
    //         $currentTime = Carbon::now()->format('H:i:s');
    //         $closeTime = Carbon::parse($ticket->result_time)->format('H:i:s');

    //         if ($currentTime >= $closeTime) {
    //             return response([
    //                 'status' => false,
    //                 'message' => 'Ticket window closed.'
    //             ], 422);
    //         }


    //         $agentId = Auth::id();

    //         if (Auth::user()->role == 'Agent') {
    //             $superAgentId = Auth::user()->super_agent_id;
    //         } else {
    //             $superAgentId = Auth::id();
    //         }

    //         try {

    //             $bill = DB::transaction(function () use ($request, $agentId, $superAgentId) {

    //                 $bill = Bill::create([
    //                     'super_agent_id' => $superAgentId,
    //                     'agent_id' => $agentId,
    //                     'ticket_id' => $request->ticketId,
    //                     'ticket_date' => date('Y-m-d')
    //                 ]);

    //                 $now = now();
    //                 $ticketId = $request->ticketId;

    //                 $numbers = collect($request->numbers)
    //                     ->map(function ($row) use ($ticketId, $bill, $agentId, $superAgentId, $now) {

    //                         $aRate = Rate::select('ticket_rate', 'user_rate')
    //                             ->where('user_id', $agentId)
    //                             ->where('mode_id', $row['mode_id'])
    //                             ->first();

    //                         $saRate = Rate::select('user_rate')
    //                             ->where('user_id', $superAgentId)
    //                             ->where('mode_id', $row['mode_id'])
    //                             ->first();

    //                         if (strlen($row['number']) == $row['group_id']) {

    //                             return [
    //                                 'bill_id' => $bill->id,
    //                                 'super_agent_id' => $superAgentId,
    //                                 'agent_id' => $agentId,
    //                                 'group_id' => $row['group_id'],
    //                                 'ticket_id' => $ticketId,
    //                                 'mode_id' => $row['mode_id'],
    //                                 'number' => $row['number'],
    //                                 'count' => $row['count'],
    //                                 'collection' => $aRate->ticket_rate * $row['count'],
    //                                 'a_rate' => $aRate->user_rate * $row['count'],
    //                                 'a_commission' => ($aRate->ticket_rate - $aRate->user_rate) * $row['count'],
    //                                 'sa_rate' => $saRate->user_rate * $row['count'],
    //                                 'sa_commission' => ($aRate->user_rate - $saRate->user_rate) * $row['count'],
    //                                 'ticket_date' => date('Y-m-d'),
    //                                 'created_at' => $now,
    //                                 'updated_at' => $now,
    //                             ];
    //                         }
    //                     })
    //                     ->toArray();

    //                 Number::insert($numbers);

    //                 return $bill;

    //             });

    //             return response()->json([
    //                 'status' => true,
    //                 'bill' => $bill->id,
    //             ]);

    //         } catch (\Throwable $e) {

    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $e->getMessage()
    //             ], 500);
    //         }
    //     } else {
    //         return response([
    //             'status' => false,
    //             'message' => 'Your Sale Status Blocked.'
    //         ], 422);
    //     }
    // }


     public function saveNumber(Request $request)
    {
        if (
            Auth::user()->login_status != 'Active' ||
            Auth::user()->sale_status != 'Active'
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Your Sale Status Blocked.'
            ], 422);
        }

        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'numbers' => 'required|array|min:1',
            'numbers.*.group_id' => 'required|exists:groups,id',
            'numbers.*.mode_id' => 'required|exists:modes,id',
            'numbers.*.number' => 'required|string|max:3',
            'numbers.*.count' => 'required|integer|min:1|max:1000'
        ]);

        // Check number length against group ID, as in your existing logic.
        foreach ($request->numbers as $row) {
            if (strlen($row['number']) != $row['group_id']) {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid number: {$row['number']}"
                ], 422);
            }
        }

        $ticket = Ticket::findOrFail($request->ticketId);

        $currentTime = Carbon::now()->format('H:i:s');
        $closeTime = Carbon::parse($ticket->result_time)->format('H:i:s');

        if ($currentTime >= $closeTime) {
            return response()->json([
                'status' => false,
                'message' => 'Ticket window closed.'
            ], 422);
        }

        $agentId = Auth::id();

        if (Auth::user()->role == 'Agent') {
            $superAgentId = Auth::user()->super_agent_id;
        } else {
            $superAgentId = Auth::id();
        }

        try {

            $result = DB::transaction(function () use ($request, $agentId, $superAgentId) {

                $ticketId = $request->ticketId;

                // Check limits before creating the bill.
                $limitResult = $this->checkNumberLimit(
                    $ticketId,
                    $request->numbers
                );

                $acceptedNumbers = $limitResult['accepted'];
                $rejectedNumbers = $limitResult['rejected'];

                // Do not create an empty bill.
                if (empty($acceptedNumbers)) {
                    return [
                        'bill' => null,
                        'rejected' => $rejectedNumbers
                    ];
                }

                $bill = Bill::create([
                    'super_agent_id' => $superAgentId,
                    'agent_id' => $agentId,
                    'ticket_id' => $ticketId,
                    'ticket_date' => date('Y-m-d')
                ]);

                $now = now();

                $insertData = collect($acceptedNumbers)
                    ->map(function ($row) use ($ticketId, $bill, $agentId, $superAgentId, $now) {

                        $aRate = Rate::select('ticket_rate', 'user_rate')
                            ->where('user_id', $agentId)
                            ->where('mode_id', $row['mode_id'])
                            ->first();

                        $saRate = Rate::select('user_rate')
                            ->where('user_id', $superAgentId)
                            ->where('mode_id', $row['mode_id'])
                            ->first();

                        if (!$aRate || !$saRate) {
                            throw new \RuntimeException(
                                "Rate not configured for mode ID: {$row['mode_id']}"
                            );
                        }

                        $count = $row['count'];

                        return [
                            'bill_id' => $bill->id,
                            'super_agent_id' => $superAgentId,
                            'agent_id' => $agentId,
                            'group_id' => $row['group_id'],
                            'ticket_id' => $ticketId,
                            'mode_id' => $row['mode_id'],
                            'number' => $row['number'],
                            'count' => $count,
                            'collection' => $aRate->ticket_rate * $count,
                            'a_rate' => $aRate->user_rate * $count,
                            'a_commission' => (
                                $aRate->ticket_rate - $aRate->user_rate
                            ) * $count,
                            'sa_rate' => $saRate->user_rate * $count,
                            'sa_commission' => (
                                $aRate->user_rate - $saRate->user_rate
                            ) * $count,
                            'ticket_date' => date('Y-m-d'),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    })
                    ->toArray();

                Number::insert($insertData);

                return [
                    'bill' => $bill,
                    'rejected' => $rejectedNumbers
                ];

            });

            if (!$result['bill']) {
                return response()->json([
                    'status' => false,
                    'message' => 'All requested numbers have reached their limits.',
                    'unsaved' => $result['rejected']
                ], 422);
            }

            return response()->json([
                'status' => true,
                'bill' => $result['bill']->id,
                'message' => empty($result['rejected'])
                    ? 'Numbers saved successfully.'
                    : 'Numbers partially saved. Some counts exceeded the limit.',
                'unsaved' => $result['rejected']
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function saveRemark(Request $request)
    {
        if (!$request->filled('billId')) {
            return response()->json([
                'status' => false,
                'message' => 'Bill ID is required.',
            ], 422);
        }

        $bill = Bill::find($request->billId);

        if (!$bill) {
            return response()->json([
                'status' => false,
                'message' => 'Bill not found.',
            ], 404);
        }

        $bill->update([
            'remarks' => $request->remark,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Remark saved successfully.',
        ]);
    }


    public function bills(Request $request)
    {
        $ticketId = $request->ticketId;



        $agentId = Auth::id();
        $bills = Bill::where('agent_id', $agentId)
            ->whereDate('ticket_date', date('Y-m-d'))
            ->where('ticket_id', $ticketId)
            ->withSum('numbers as total_count', 'count')
            ->withSum('numbers as total_collection', 'collection')
            ->latest('id')
            ->get()
            ->map(function ($bill) {
                $bill->formatted_created_at = $bill->created_at?->format('d-M-Y h:i A');
                return $bill;
            });
        return response()->json(['status' => true, 'bills' => $bills], 200);

    }

    public function billDetails(Request $request)
    {
        // if (Auth::user()->role == 'Agent') {
        $agentId = Auth::user()->id;
        $numbers = Number::with(['ticket:id,short_name', 'mode:id,name'])
            ->where('agent_id', $agentId)
            ->where('bill_id', $request->billId)
            ->get();
        // } else {
        //     $superAgentId = Auth::user()->id;
        //     $numbers = Number::with(['ticket:id,short_name', 'mode:id,name'])
        //         ->where('super_agent_id', $superAgentId)
        //         ->where('bill_id', $request->billId)
        //         ->get();
        // }

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
                    'mode' => $number->mode->name,
                    'number' => $number->number,
                    'number_id' => $number->id,
                    'count' => $number->count,
                    'collection' => $number->collection
                ];
            }

            return response([
                'status' => true,
                'rows' => $rows,
                'slot' => date('h:i A', strtotime($bill->ticket->result_time)),
                'created_at' => date('Y-M-d h:i A', strtotime($bill->created_at)),
                'bill_id' => $bill->id,
                'remarks' => $bill->remarks,
                'delete_button' => $deleteButtons
            ]);

        } else {
            return response([
                'status' => false,
                'message' => 'Unauthorized!'
            ]);
        }

    }

    // public function updateNumber(Request $request)
    // {
    //     $request->validate([
    //         'billId' => 'required|exists:bills,id',
    //         'numberId' => 'required|exists:numbers,id',
    //         'count' => 'required|integer|min:1|max:1000',
    //     ]);

    //     $count = (int) $request->count;

    //     $bill = Bill::with('ticket:id,result_time')
    //         ->where('agent_id', Auth::id())
    //         ->find($request->billId);


    //     if (!$bill) {
    //         return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
    //     }

    //     // Lock check
    //     if ($this->isBillLocked($bill)) {
    //         return response()->json(['status' => false, 'message' => 'Bill locked'], 422);
    //     }

    //     try {

    //         $number = Number::where('bill_id', $bill->id)
    //             ->where('id', $request->numberId)
    //             ->firstOrFail();

    //         $aRate = Rate::select('ticket_rate', 'user_rate')
    //             ->where('user_id', $number->agent_id)
    //             ->where('mode_id', $number->mode_id)
    //             ->first();
    //         $saRate = Rate::select('user_rate')
    //             ->where('user_id', $number->super_agent_id)
    //             ->where('mode_id', $number->mode_id)
    //             ->first();

    //         $number->update([
    //             'count' => $count,
    //             'collection' => $aRate->ticket_rate * $count,
    //             'a_rate' => $aRate->user_rate * $count,
    //             'a_commission' => ($aRate->ticket_rate - $aRate->user_rate) * $count,
    //             'sa_rate' => $saRate->user_rate * $count,
    //             'sa_commission' => ($aRate->user_rate - $saRate->user_rate) * $count,
    //         ]);
    //         return response()->json(['status' => true]);
    //     } catch (\Throwable $e) {
    //         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }


    public function updateNumber(Request $request)
    {
        $request->validate([
            'billId' => 'required|exists:bills,id',
            'numberId' => 'required|exists:numbers,id',
            'count' => 'required|integer|min:1|max:1000',
        ]);

        $bill = Bill::with('ticket:id,result_time')
            ->where('agent_id', Auth::id())
            ->find($request->billId);

        if (!$bill) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        if ($this->isBillLocked($bill)) {
            return response()->json([
                'status' => false,
                'message' => 'Bill locked'
            ], 422);
        }

        try {

            $result = DB::transaction(function () use ($request, $bill) {

                $number = Number::where('bill_id', $bill->id)
                    ->where('id', $request->numberId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $count = (int) $request->count;

                // Exclude this record from the existing total.
                $limitResult = $this->checkNumberLimit(
                    $number->ticket_id,
                    [
                        [
                            'mode_id' => $number->mode_id,
                            'number' => $number->number,
                            'count' => $count
                        ]
                    ],
                    [$number->id]
                );

                $accepted = $limitResult['accepted'];
                $rejected = $limitResult['rejected'];

                if (empty($accepted)) {
                    return [
                        'updated' => false,
                        'rejected' => $rejected
                    ];
                }

                // This is the count allowed by the limit.
                $allowedCount = (int) $accepted[0]['count'];

                $aRate = Rate::select('ticket_rate', 'user_rate')
                    ->where('user_id', $number->agent_id)
                    ->where('mode_id', $number->mode_id)
                    ->first();

                $saRate = Rate::select('user_rate')
                    ->where('user_id', $number->super_agent_id)
                    ->where('mode_id', $number->mode_id)
                    ->first();

                if (!$aRate || !$saRate) {
                    throw new \RuntimeException(
                        "Rate not configured for mode ID: {$number->mode_id}"
                    );
                }

                $number->update([
                    'count' => $allowedCount,
                    'collection' => $aRate->ticket_rate * $allowedCount,
                    'a_rate' => $aRate->user_rate * $allowedCount,
                    'a_commission' => (
                        $aRate->ticket_rate - $aRate->user_rate
                    ) * $allowedCount,
                    'sa_rate' => $saRate->user_rate * $allowedCount,
                    'sa_commission' => (
                        $aRate->user_rate - $saRate->user_rate
                    ) * $allowedCount,
                ]);

                return [
                    'updated' => true,
                    'saved_count' => $allowedCount,
                    'rejected' => $rejected
                ];
            });

            if (!$result['updated']) {
                return response()->json([
                    'status' => false,
                    'message' => 'No count available for this number.',
                    'unsaved' => $result['rejected']
                ], 422);
            }

            return response()->json([
                'status' => true,
                'message' => empty($result['rejected'])
                    ? 'Number updated successfully.'
                    : 'Number partially updated. Some counts exceeded the limit.',
                'saved_count' => $result['saved_count'],
                'unsaved' => $result['rejected']
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
        $bill = Bill::findOrFail($request->billId);
        // ownership check

        if ($bill->agent_id != Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
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
        if ($bill->agent_id != Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
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

    public function result(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'resultDate' => 'required|date',
        ]);
        try {
            $result = Result::where('ticket_id', $request->ticketId)
                ->whereDate('result_date', $request->resultDate)
                ->first();
            if (!$result) {
                return response()->json([
                    'status' => false,
                    'message' => 'Result not found.'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'result' => $result
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function salesSummary(Request $request)
    {
        $agentId = null;
        $superAgentId = null;

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
        }

        $result = $query->groupBy(DB::raw('DATE(ticket_date)'))
            ->orderBy('sale_date', 'asc')
            ->get();

        return response()->json(['status' => true, 'data' => $result]);
    }

    public function salesUsers(Request $request)
    {
        $agentId = null;
        $superAgentId = null;

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
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
                'remark' => $bill->remarks,
                'numbers' => $bill->numbers
            ];
        });
        return response()->json(['status' => true, 'data' => $report]);
    }

    public function numberWiseReport(Request $request)
    {
        $result = $this->getNumberWiseData($request);
        return response()->json(['status' => true, 'data' => $result]);
    }

    public function numberWisePdf(Request $request)
    {
        $ticket = 'All';
        if ($request->filled('ticketId')) {
            $ticket = Ticket::where('id', $request->ticketId)->value('short_name');
        }
        if ($request->filled('groupColumn') && $request->groupColumn == 1) {
            $column = "no";
        } else {
            $column = "yes";
        }
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
        $agentId = null;
        $superAgentId = null;
        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
        }
        $result = $query->groupBy('agent_id')
            ->orderByDesc('rate_total')
            ->get();
        return response()->json(['status' => true, 'data' => $result]);
    }

    public function netPay(Request $request)
    {
        $agentId = null;
        $superAgentId = null;
        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
        }
        $result = $query->groupBy('agent_id')
            ->orderByDesc('rate_total')
            ->get();
        return response()->json(['status' => true, 'data' => $result]);
    }

    public function winningSummary(Request $request)
    {
        $agentId = null;
        $superAgentId = null;
        if (Auth::user()->role === 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }
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
        } // User scope
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
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
        $agentId = null;
        $superAgentId = null;

        if (Auth::user()->role == 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('super_agent_id', $superAgentId);
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





    private function getNumberWiseData(Request $request)
    {
        $agentId = null;
        $superAgentId = null;
        if (Auth::user()->role === 'Agent') {
            $agentId = Auth::id();
        } else {
            $superAgentId = Auth::id();
        }

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
        if ($agentId) {
            $query->where('numbers.agent_id', $agentId);
        }
        if ($superAgentId) {
            $query->where('numbers.super_agent_id', $superAgentId);
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

    private function checkNumberLimit($ticketId, $numbers, $excludeIds = [])
    {
        $modeIds = collect($numbers)
            ->pluck('mode_id')
            ->unique()
            ->values();

        // Lock configured limits during this transaction.
        $limits = DB::table('limits')
            ->whereIn('mode_id', $modeIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('mode_id');

        // Get existing totals for each mode + number.
        $existingCounts = Number::where('ticket_id', $ticketId)
            ->whereIn('mode_id', $modeIds)
            ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->select(
                'mode_id',
                'number',
                DB::raw('SUM(`count`) as total_count')
            )
            ->groupBy('mode_id', 'number')
            ->get()
            ->keyBy(function ($row) {
                return $row->mode_id . '|' . $row->number;
            });

        $accepted = [];
        $rejected = [];

        foreach ($numbers as $row) {
            $modeId = $row['mode_id'];
            $number = (string) $row['number'];
            $requestedCount = (int) $row['count'];

            $limit = $limits->get($modeId);

            if (!$limit) {
                throw new \RuntimeException(
                    "Limit not configured for mode ID: {$modeId}"
                );
            }

            $key = $modeId . '|' . $number;

            $existing = $existingCounts->get($key);
            $alreadySaved = $existing ? (int) $existing->total_count : 0;

            $remaining = max(0, (int) $limit->limit - $alreadySaved);

            $saveCount = min($requestedCount, $remaining);
            $unsavedCount = $requestedCount - $saveCount;

            if ($saveCount > 0) {
                $accepted[] = array_merge($row, [
                    'count' => $saveCount
                ]);

                // Important when the same number appears more than once
                // in the same request.
                $existingCounts->put($key, (object) [
                    'total_count' => $alreadySaved + $saveCount
                ]);
            }

            if ($unsavedCount > 0) {
                $rejected[] = [
                    'mode_id' => $modeId,
                    'number' => $number,
                    'requested_count' => $requestedCount,
                    'saved_count' => $saveCount,
                    'unsaved_count' => $unsavedCount,
                    'limit' => (int) $limit->limit,
                    'message' => "Limit exceeded for mode {$modeId}, number {$number}."
                ];
            }
        }

        return [
            'accepted' => $accepted,
            'rejected' => $rejected
        ];
    }







}
