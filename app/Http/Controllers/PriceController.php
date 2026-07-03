<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Price;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    public function index(Request $request)
    {
        $prices = Price::with([
            'scheme:id,name',
            'mode:id,name'
        ])
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->whereHas('scheme', function ($scheme) use ($request) {
                        $scheme->where('name', 'like', '%' . $request->search . '%');
                    })
                        ->orWhereHas('mode', function ($mode) use ($request) {
                            $mode->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhere('winner_amount', 'like', '%' . $request->search . '%');

                });

            })
            ->paginate(10)
            ->withQueryString();

        return view('price.index', compact('prices'));
    }

      public function edit($id)
    {
        $schemes = Scheme::pluck('name', 'id');
        $modes = Mode::pluck('name', 'id');
        $price = Price::findOrFail($id);
        return view('price.edit', compact('price', 'schemes', 'modes'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'winner_amount' => 'required|numeric|decimal:0,2|min:0',
            'super_agent_amount' => 'required|numeric|decimal:0,2|min:0',
            'agent_amount' => 'required|numeric|decimal:0,2|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('price.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Price::where('id', $request->id)->update([
                'winner_amount' => $request->winner_amount,
                'super_agent_amount' => $request->super_agent_amount,
                'agent_amount' => $request->agent_amount
            ]);
            return redirect()->route('price.index')->with('success', 'Price details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('price.edit')->with('error', $th->getMessage());
        }
    }

}
