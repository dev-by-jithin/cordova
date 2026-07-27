<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Price;
use App\Models\Rate;
use App\Models\Scheme;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SchemeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $schemes = Scheme::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();


        return view('scheme.index', compact('schemes', 'search'));
    }

    public function create(Request $request)
    {
        $modes = Mode::with(['group:id,name'])->select('id', 'group_id', 'name')->orderBy('sort_order', 'DESC')->get();
        return view('scheme.create', compact('modes'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:schemes,name|max:20'
        ]);

        if ($validator->fails()) {

            return redirect()->route('scheme.create')->withErrors($validator)->withInput();
        }

        try {

            DB::transaction(function () use ($request) {

                $scheme = Scheme::create([
                    'name' => $request->name,
                    'is_active' => 'No',
                ]);

                $modes = Mode::select('id', 'group_id')->get();

                foreach ($modes as $mode) {
                    if ($mode->group_id == 1) {
                        Price::insert([
                            'scheme_id' => $scheme->id,
                            'mode_id' => $mode->id,
                            'position' => 1,
                            'count' => 1,
                            'created_at' => now()
                        ]);
                    }

                    if ($mode->group_id == 2) {
                        Price::insert([
                            'scheme_id' => $scheme->id,
                            'mode_id' => $mode->id,
                            'position' => 1,
                            'count' => 1,
                            'created_at' => now()
                        ]);
                    }

                    if ($mode->group_id == 3 && $mode->id == 7) {
                        Price::insert([
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 1,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 2,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 3,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 4,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 5,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 6,
                                'count' => 1,
                                'created_at' => now()
                            ],
                        ]);
                    }

                    if ($mode->group_id == 3 && $mode->id == 8) {
                        Price::insert([
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 1,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 2,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 3,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 4,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 5,
                                'count' => 1,
                                'created_at' => now()
                            ],
                            [
                                'scheme_id' => $scheme->id,
                                'mode_id' => $mode->id,
                                'position' => 6,
                                'count' => 30,
                                'created_at' => now()
                            ],
                        ]);
                    }
                }

            });

            return redirect()
                ->route('scheme.index')
                ->with('success', 'New scheme created successfully.');

        } catch (\Throwable $th) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $scheme = Scheme::findOrFail($id);
        return view('scheme.edit', compact('scheme'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|unique:schemes,name,' . $request->id
        ]);

        if ($validator->fails()) {
            return redirect()->route('scheme.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Scheme::where('id', $request->id)->update([
                'name' => $request->name,
            ]);
            return redirect()->route('scheme.index')->with('success', 'Scheme details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('scheme.edit')->with('error', $th->getMessage());
        }
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $isActive = $request->isActive;

        if ($isActive == 'Yes') {

            $nullPriceCount = Price::where('scheme_id', $id)
                ->whereNull('winner_amount')
                ->whereNull('super_agent_amount')
                ->whereNull('agent_amount')
                ->count();

            if ($nullPriceCount > 0) {
                return response([
                    'status' => false,
                    'message' => 'Please add price, winner price, super agent price and agent price to activate this scheme.'
                ]);
            } else {

                Scheme::where('id', $id)->update(['is_active' => 'Yes']);

                return response([
                    'status' => true,
                    'message' => 'Scheme activated successfully.'
                ]);

            }


        } else {

            try {

                Scheme::where('id', $id)->update(['is_active' => 'No']);

                return response([
                    'status' => false,
                    'message' => 'Scheme deactivated successfully.'
                ]);
            } catch (\Throwable $th) {
                return response($th->getMessage());
            }

        }

    }


    public function show(Request $request)
    {
        $scheme = Scheme::findOrFail($request->id);

        $modes = Mode::with(['group:id,name'])->select('id', 'group_id', 'name')->orderBy('sort_order', 'DESC')->get();

        $prices = Price::where('scheme_id', $request->id)->get();

        $priceArray = [];

        foreach ($modes as $mode) {

            foreach ($prices as $price) {

                if ($mode->id == $price->mode_id) {

                    $priceArray[$mode->name . "@" . $mode->group->name][] = [
                        'position' => $price->position,
                        'count' => $price->count,
                        'winnerAmount' => $price->winner_amount,
                   'superAgentAmount' => $price->super_agent_amount,
                        'agentAmount' => $price->agent_amount
                    ];
                }
            }
        }

        return response([
            'scheme' => $scheme,
            'prices' => $priceArray
        ]);
    }
}
