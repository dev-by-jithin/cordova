<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Mode;
use App\Models\Number;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public function index(Request $request)
    {
        $numbers = Number::with([
            'ticket:id,name',
            'mode:id,name',
            'superAgent:id,username',
            'agent:id,username',
        ])
            ->when($request->filled('group_id'), function ($query) use ($request) {
                $query->where('group_id', $request->group_id);
            })
            ->when($request->filled('ticket_id'), function ($query) use ($request) {
                $query->where('ticket_id', $request->ticket_id);
            })
            ->when($request->filled('mode_id'), function ($query) use ($request) {
                $query->where('mode_id', $request->mode_id);
            })
            ->when($request->filled('super_agent_id'), function ($query) use ($request) {
                $query->where('super_agent_id', $request->super_agent_id);
            })
            ->when($request->filled('agent_id'), function ($query) use ($request) {
                $query->where('agent_id', $request->agent_id);
            })
            ->when($request->filled('created_at'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->created_at);
            })
            ->when($request->filled('bill_no'), function ($query) use ($request) {
                $query->where('bill_id', $request->bill_no);
            })
            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('number', 'like', "%{$search}%")
                        ->orWhere('count', 'like', "%{$search}%")
                        ->orWhere('rate', 'like', "%{$search}%")
                        ->orWhere('collection', 'like', "%{$search}%")
                        ->orWhere('commission', 'like', "%{$search}%")
                        ->orWhereHas('ticket', function ($ticket) use ($search) {
                            $ticket->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('mode', function ($mode) use ($search) {
                            $mode->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('superAgent', function ($user) use ($search) {
                            $user->where('username', 'like', "%{$search}%");
                        })
                        ->orWhereHas('agent', function ($user) use ($search) {
                            $user->where('username', 'like', "%{$search}%");
                        });

                });

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $groups = Group::pluck('name', 'id');

        $tickets = Ticket::orderBy('sort_order')
            ->pluck('name', 'id');

        $modes = Mode::pluck('name', 'id');

        $superAgents = User::where('role', 'Super Agent')
            ->orderBy('username')
            ->pluck('username', 'id');

        $agents = User::where('role', 'Agent')
            ->orderBy('username')
            ->pluck('username', 'id');

        return view('number.index', compact(
            'numbers',
            'groups',
            'tickets',
            'modes',
            'superAgents',
            'agents'
        ));
    }

    public function fake(Request $request)
    {
        return view('number.fake');
    }

    public function findFake(Request $request)
    {

        $numbers = Number::with([
                'ticket:id,name,result_time',
                'mode:id,name',
                'agent:id,username',
                'superAgent:id,username'
            ])
            ->whereDate('created_at', $request->createdAt)
            ->where(function ($query) {

                $query->whereRaw('CHAR_LENGTH(number) <> group_id')

                    ->orWhereExists(function ($q) {

                        $q->selectRaw(1)
                            ->from('tickets')
                            ->whereColumn('tickets.id', 'numbers.ticket_id')
                            ->whereRaw('TIME(numbers.created_at) >= tickets.result_time');

                    });
            })
            ->get();

            $numbers->each(function ($number) {
                $number->created = $number->created_at->format('d-m-Y H:i:s');
            });

            return response($numbers);
    }

    public function fakeDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:numbers,id',
        ]);

        $number = Number::findOrFail($request->id);
        $number->delete();

        return response()->json([
            'status' => true,
            'message' => 'Fake number deleted successfully.'
        ]);
    }
}
