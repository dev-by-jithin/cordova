<?php

namespace App\Http\Controllers;

use App\Models\Mode;
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
        return view('scheme.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:schemes,name|max:20',
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

                $tickets = Ticket::pluck('id');
                $modes = Mode::pluck('id');

                $data = [];

                foreach ($tickets as $ticketId) {
                    foreach ($modes as $modeId) {
                        $rate = in_array($modeId, [1, 2, 3]) ? 30 : 10;
                        $data[] = [
                            'ticket_id' => $ticketId,
                            'mode_id' => $modeId,
                            'scheme_id' => $scheme->id,
                            'rate' => $rate,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                Rate::insert($data);
            });

            return redirect()
                ->route('scheme.index')
                ->with('success', 'New scheme created successfully.');

        } catch (\Throwable $th) {

            return redirect()
                ->route('scheme.create')
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

            $nullRatesCount = Rate::where('scheme_id', $id)
                ->whereNull('admin_amount')
                ->whereNull('super_agent_amount')
                ->whereNull('agent_amount')
                ->count();

            if ($nullRatesCount > 0) {
                return response([
                    'status' => false,
                    'message' => 'Please add rates, admin rate, super agent rate and agent rate to activate this scheme.'
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
}
