<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use Illuminate\Http\Request;

class ModeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $modes = Mode::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();


        return view('mode.index', compact('modes', 'search'));
    }
}
