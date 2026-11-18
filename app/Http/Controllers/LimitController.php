<?php

namespace App\Http\Controllers;

use App\Models\Limit;
use App\Models\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LimitController extends Controller
{
    public function index(Request $request)
    {
        $limits = Limit::with([
            'mode:id,name'
        ])
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->orWhereHas('mode', function ($mode) use ($request) {
                        $mode->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhere('limit', 'like', '%' . $request->search . '%');

                });

            })
            ->paginate(10)
            ->withQueryString();

        return view('limit.index', compact('limits'));
    }

    public function edit($id)
    {
        $limit = Limit::findOrFail($id);
        $mode = Mode::findOrFail($limit->mode_id);
        return view('limit.edit', compact('limit', 'mode'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('limit.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            Limit::where('id', $request->id)->update([
                'limit' => $request->limit
            ]);
            return redirect()->route('limit.index')->with('success', 'Limit details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('limit.edit')->with('error', $th->getMessage());
        }
    }
}
