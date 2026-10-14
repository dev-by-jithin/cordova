<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\payments;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $superAgents = User::select('id', 'username')->where('role', 'Super Agent')->get();
        $payments = payments::with(['superAgent:id,username'])->latest()->paginate(10);
        return view('payment.index', compact('superAgents', 'payments'));
    }

    public function pending(Request $request)
    {
        $request->validate([
            'super_agent_id' => 'nullable|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $query = Number::with([
            'agent:id,username',
            'superAgent:id,username',
        ])
            ->select([
                'agent_id',
                'super_agent_id',
                'number',
                'count',
                'prize_position',
                'winner_prize',
                'a_prize_commission',
                'sa_rate',
            ])
            ->whereDate('ticket_date', '>=', $request->from_date)
            ->whereDate('ticket_date', '<=', $request->to_date)
            ->where('payment_status', 'Pending');

        if ($request->filled('super_agent_id')) {
            $query->where('super_agent_id', $request->super_agent_id);
        }

        $result = $query->get();

        return response()->json([
            'status' => true,
            'data' => $result,
        ]);
    }

    public function settled(Request $request)
    {
        $request->validate([
            'super_agent_id' => 'required|exists:users,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);

        $payment = payments::create([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'sale' => $request->sale,
            'winning' => $request->winning,
            'commission' => $request->commission,
            'net' => $request->net,
            'super_agent_id' => $request->super_agent_id
        ]);

        $number = Number::with([
            'agent:id,username',
            'superAgent:id,username',
        ])
            ->whereDate('ticket_date', '>=', $request->from_date)
            ->whereDate('ticket_date', '<=', $request->to_date)
            ->where('payment_status', 'Pending')
            ->where('super_agent_id', $request->super_agent_id);

        $number->update(
            [
                'payment_status' => 'Paid',
                'payment_id' => $payment->id
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Payment Settled.',
        ]);
    }
}
