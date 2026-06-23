<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::query()
            ->whereIn('role', ['Agent', 'Super Agent'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view('user.index', compact('users', 'search'));
    }

    public function create(Request $request)
    {
        $schemes = Scheme::where('is_active', '=', 'yes')->pluck('name', 'id');
        $superAgents = User::where('role', 'Super Agent')->pluck('username', 'id');
        return view('user.create', compact('superAgents', 'schemes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:20',
            'username' => 'required|unique:users,username|max:10',
            'password' => 'required|max:10',
            'email' => 'nullable|email|unique:users,email',
            'role' => 'required|in:Super Agent,Agent',
            'super_agent' => 'required_if:role,Agent|nullable|exists:users,id',
            'scheme_id' => 'required|exists:schemes,id',
            'is_active' => 'required|in:Yes,No',
            'description' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'super_agent_id' => $request->role === 'Agent' ? $request->super_agent : null,
                'is_active' => $request->is_active,
                'scheme_id' => $request->scheme_id,
                'description' => $request->description
            ]);
            return redirect()->route('user.index')->with('success', 'New user created successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('user.create')->with('error', $th->getMessage());
        }

    }


    public function edit($id)
    {
        $schemes = Scheme::where('is_active', '=', 'yes')->pluck('name', 'id');
        $superAgents = User::where('role', 'Super Agent')->pluck('username', 'id');
        $user = User::findOrFail($id);
        return view('user.edit', compact('user', 'superAgents', 'schemes'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:20',
            'username' => 'required|max:10|unique:users,username,' . $request->id,
            'password' => 'required|max:10',
            'email' => 'nullable|email|unique:users,email,' . $request->id,
            'role' => 'required|in:Super Agent,Agent',
            'super_agent' => 'required_if:role,Agent|nullable|exists:users,id',
            'is_active' => 'required|in:Yes,No',
            'scheme_id' => 'required|exists:schemes,id',
            'description' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit', $request->id)->withErrors($validator)->withInput();
        }

        try {
            User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'super_agent_id' => $request->role === 'Agent' ? $request->super_agent : null,
                'is_active' => $request->is_active,
                'scheme_id' => $request->scheme_id,
                'description' => $request->description
            ]);
            return redirect()->route('user.index')->with('success', 'User details updated successfully.');
        } catch (\Throwable $th) {

            return redirect()->route('user.edit')->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

}
