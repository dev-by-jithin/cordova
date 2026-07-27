<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Scheme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $rates = Rate::with([
            'ticket:id,name',
            'mode:id,name',
            'user:id,username,role'
        ])
            ->when($request->user_id, function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
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

        $users = User::whereIn('role', ['Super Agent', 'Agent'])
                        ->orderBy('username')
                        ->pluck('username', 'id');
        return view('rate.index', compact('rates', 'users'));
    }

    public function edit($id)
    {
        $rate = Rate::findOrFail($id);
        return view('rate.edit', compact('rate'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric|max:50|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->route('rate.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Rate::where('id', $request->id)->update([
                'rate' => $request->rate
            ]);
            return redirect()->route('rate.index')->with('success', 'Rate updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('rate.edit')->with('error', $th->getMessage());
        }
    }
}
