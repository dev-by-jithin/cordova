<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $rates = Rate::with([
            'ticket:id,name',
            'mode:id,name'
        ])
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->whereHas('ticket', function ($ticket) use ($request) {
                        $ticket->where('name', 'like', '%' . $request->search . '%');
                    })
                        ->orWhereHas('mode', function ($mode) use ($request) {
                            $mode->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhere('rate', 'like', '%' . $request->search . '%');

                });

            })
            ->paginate(10)
            ->withQueryString();

        return view('rate.index', compact('rates'));
    }
}
