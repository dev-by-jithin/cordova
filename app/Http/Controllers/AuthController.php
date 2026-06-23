<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|max:20|min:3'
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'Admin',
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Your account has been created.');
    }

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->onlyInput('email');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 'Yes'])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Hi, welcome ' . Auth::user()->name);
        } else {
            return back()->with('error', 'Invalid email or password !');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function profile(Request $request)
    {
        $user = User::find(1);
        return view('auth.profile', compact('user'));
    }

      public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:20',
            'email' => 'nullable|email|unique:users,email,' . $request->id,
            'password' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('profile')->with('success', 'Profile details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('profile')->with('error', $th->getMessage());
        }
    }
}
