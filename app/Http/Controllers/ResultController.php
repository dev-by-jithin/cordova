<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Number;
use App\Models\Price;
use App\Models\Result;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::select('id', 'name')->orderBy('result_time', 'ASC')->get();
        $modes = Mode::select('id', 'name')->orderBy('sort_order', 'DESC')->get();
        return view('result.index', compact('tickets','modes'));
    }

    public function publish(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'result_date' => 'required|date|unique:results,result_date,NULL,id,ticket_id,' . $request->ticket_id,
            'super_position_1' => 'required|digits:3',
            'super_position_2' => 'required|digits:3',
            'super_position_3' => 'required|digits:3',
            'super_position_4' => 'required|digits:3',
            'super_position_5' => 'required|digits:3',
            'encouragement_prizes' => 'required|array|size:30',
            'encouragement_prizes.*' => 'required|string|size:3|regex:/^\d{3}$/|distinct',
            'box_position_1' => 'required|digits:3',
            'box_position_2' => 'required|digits:3',
            'box_position_3' => 'required|digits:3',
            'box_position_4' => 'nullable|digits:3',
            'box_position_5' => 'nullable|digits:3',
            'box_position_6' => 'nullable|digits:3',
            'ab' => 'required|digits:2',
            'bc' => 'required|digits:2',
            'ac' => 'required|digits:2',
            'a' => 'required|digits:1',
            'b' => 'required|digits:1',
            'c' => 'required|digits:1',
        ]);

        $validator->after(function ($validator) use ($request) {
            $superPositions = [
                $request->super_position_1,
                $request->super_position_2,
                $request->super_position_3,
                $request->super_position_4,
                $request->super_position_5,
            ];

            foreach ($request->encouragement_prizes ?? [] as $index => $prize) {
                if (in_array($prize, $superPositions, true)) {
                    $validator->errors()->add( "encouragement_prizes" .$index+1, "Encouragement prize #" . ($index + 1) . " ($prize) cannot match any super position number." );
                }
            }

            $ticket = Ticket::find($request->ticket_id);
            if ($ticket) {

                $now = Carbon::now();
                $closeTime = Carbon::today()->setTimeFromTimeString($ticket->result_time);

                if ($now->lt($closeTime)) {
                    $validator->errors()->add( 'ticket_id', 'The ticket window is not closed yet.' );
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }



        try {

            DB::transaction(function () use ($request) {

                $prizes = $request->encouragement_prizes;

                sort($prizes, SORT_NUMERIC);

                $result = Result::create([
                    'ticket_id' => $request->ticket_id,
                    'result_date' => $request->result_date,
                    'super_position_1' => $request->super_position_1,
                    'super_position_2' => $request->super_position_2,
                    'super_position_3' => $request->super_position_3,
                    'super_position_4' => $request->super_position_4,
                    'super_position_5' => $request->super_position_5,
                    'super_encouragement_prize' => json_encode($prizes),
                    'box_position_1' => $request->box_position_1,
                    'box_position_2' => $request->box_position_2,
                    'box_position_3' => $request->box_position_3,
                    'box_position_4' => $request->box_position_4,
                    'box_position_5' => $request->box_position_5,
                    'box_position_6' => $request->box_position_6,
                    'ab' => $request->ab,
                    'bc' => $request->bc,
                    'ac' => $request->ac,
                    'a' => $request->a,
                    'b' => $request->b,
                    'c' => $request->c
                ]);


                $this->processPrize($result, $result->super_position_1, 8, 1);
                $this->processPrize($result, $result->super_position_2, 8, 2);
                $this->processPrize($result, $result->super_position_3, 8, 3);
                $this->processPrize($result, $result->super_position_4, 8, 4);
                $this->processPrize($result, $result->super_position_5, 8, 5);

                $encouragementPrizes = json_decode($result->super_encouragement_prize, true);
                foreach ($encouragementPrizes as $prizeNumber) {
                    $this->processPrize($result, $prizeNumber, 8, 6);
                }

                $this->processPrize($result, $result->box_position_1, 7, 1);
                $this->processPrize($result, $result->box_position_2, 7, 2);
                $this->processPrize($result, $result->box_position_3, 7, 3);
                $this->processPrize($result, $result->box_position_4, 7, 4);
                $this->processPrize($result, $result->box_position_5, 7, 5);
                $this->processPrize($result, $result->box_position_6, 7, 6);

                $this->processPrize($result, $result->ac, 6, 1);
                $this->processPrize($result, $result->bc, 5, 1);
                $this->processPrize($result, $result->ab, 4, 1);
                $this->processPrize($result, $result->c, 3, 1);
                $this->processPrize($result, $result->b, 2, 1);
                $this->processPrize($result, $result->a, 1, 1);

            });

            return response()->json(['status' => true, 'message' => 'Result published successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }



    }

    public function history(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'resultDate' => 'required|date',
            'modeId' => 'required|exists:modes,id',
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

    public function cancel(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
            'resultDate' => 'required|date'
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

            Number::where('ticket_id', $request->ticketId)
                    ->whereDate('ticket_date', $request->resultDate)
                    ->update([
                        'prize_position' => null,
                        'a_prize_commission' => null,
                        'winner_prize' => null
                    ]);

            $result->delete();

            return response()->json([
                'status' => true,
                'message' => 'Result cancelled successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function getSchemeId($agentId)
    {
        return User::where('id', $agentId)->where('role', 'Agent')->value('scheme_id');
    }

    private function getPrize($schemeId, $modeId, $position)
    {
        return Price::where('scheme_id', $schemeId)
            ->where('mode_id', $modeId)
            ->where('position', $position)
            ->first(['winner_amount', 'agent_amount']);
    }

    private function updatePrize($id, $position, $count, $agentAmount, $winnerAmount): void
    {
        Number::whereKey($id)->update([
            'prize_position' => $position,
            'a_prize_commission' => round($agentAmount * $count, 2),
            'winner_prize' => round($winnerAmount * $count, 2),
            'updated_at' => now(),
        ]);
    }

    private function processPrize($result, $numberValue, $modeId, $position): void
    {
        if ($numberValue === null || $numberValue === '') {
            return;
        }

        $numbers = Number::select('id', 'agent_id', 'count')
            ->whereDate('ticket_date', $result->result_date)
            ->where('ticket_id', $result->ticket_id)
            ->where('mode_id', $modeId)
            ->where('number', $numberValue)
            ->get();

        foreach ($numbers as $number) {
            $schemeId = $this->getSchemeId($number->agent_id);
            if (!$schemeId) {
                continue;
            }

            $prize = $this->getPrize($schemeId, $modeId, $position);
            if (!$prize) {
                continue;
            }

            $this->updatePrize($number->id, $position, $number->count, (float) $prize->agent_amount, (float) $prize->winner_amount);
        }
    }

}
