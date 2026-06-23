<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Http\Request;
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
            Scheme::create([
                'name' => $request->name,
                'is_active' => 'No'
            ]);
            return redirect()->route('scheme.index')->with('success', 'New scheme created successfully.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('scheme.create')->with('error', $th->getMessage());
        }

    }
}
