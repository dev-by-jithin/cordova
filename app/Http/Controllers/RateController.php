<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $rates = Rate::with([
            'ticket:id,name',
            'mode:id,name',
            'scheme:id,name'
        ])
            ->when($request->scheme, function ($query) use ($request) {
                $query->where('scheme_id', $request->scheme);
            })
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

        $schemes = Scheme::pluck('name', 'id');
        return view('rate.index', compact('rates', 'schemes'));
    }

    public function edit($id)
    {
        $rate = Rate::findOrFail($id);
        return view('rate.edit', compact('rate'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric|max:50',
            'admin_amount' => 'required|numeric|decimal:0,2|min:0',
            'super_agent_amount' => 'required|numeric|decimal:0,2|min:0',
            'agent_amount' => 'required|numeric|decimal:0,2|min:0',
        ]);

        $validator->after(function ($validator) use ($request) {

            $total = (float) $request->admin_amount
                + (float) $request->super_agent_amount
                + (float) $request->agent_amount;

            if (round($total, 2) != round((float) $request->rate, 2)) {
                $validator->errors()->add(
                    'total_amount',
                    'The sum of Admin Amount, Super Agent Amount and Agent Amount must be equal to the Rate.'
                );
            }
        });

        if ($validator->fails()) {
            return redirect()->route('price.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Rate::where('id', $request->id)->update([
                'rate' => $request->rate,
                'admin_amount' => $request->admin_amount,
                'super_agent_amount' => $request->super_agent_amount,
                'agent_amount' => $request->agent_amount
            ]);
            return redirect()->route('rate.index')->with('success', 'Rate details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('rate.edit')->with('error', $th->getMessage());
        }
    }
}
