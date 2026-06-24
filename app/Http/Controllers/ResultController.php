<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        return view('result.index');
    }
}
