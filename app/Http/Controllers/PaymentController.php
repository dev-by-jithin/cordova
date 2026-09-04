<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $superAgents = User::select('id', 'username')->where('role', 'Super Agent')->get();
        return view('payment.index', compact('superAgents'));
    }
}
