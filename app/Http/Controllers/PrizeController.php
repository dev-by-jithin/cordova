<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrizeController extends Controller
{
    public function index(Request $request)
    {
        $prizes = Prize::with([
            'mode:id,name'
        ])
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->orWhereHas('mode', function ($mode) use ($request) {
                        $mode->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhere('prize', 'like', '%' . $request->search . '%');

                });

            })
            ->paginate(10)
            ->withQueryString();

        return view('prize.index', compact('prizes'));
    }

      public function edit($id)
    {
        $modes = Mode::pluck('name', 'id');
        $prize = Prize::findOrFail($id);
        return view('prize.edit', compact('prize', 'modes'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prize' => 'required|numeric|decimal:0,2|min:0',
            'agent_commission' => 'required|numeric|decimal:0,2|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('prize.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Prize::where('id', $request->id)->update([
                'prize' => $request->prize,
                'agent_commission' => $request->agent_commission
            ]);
            return redirect()->route('prize.index')->with('success', 'Prize details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('prize.edit')->with('error', $th->getMessage());
        }
    }

}
