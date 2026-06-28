<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users,username',
            'password' => 'min:3|max:10|confirmed',
            'scheme_id' => 'required|exists:schemes,id'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $superAgentId = $request->user()->id;

        try {
            User::create([
                'username' => $request->user_name,
                'super_agent_id' => $superAgentId,
                'scheme_id' => $request->scheme_id,
                'role' => 'Agent',
                'password' => bcrypt($request->password)
            ]);
            return response([
                'status' => true,
                'message' => 'The agent has been created successfully.'
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return response(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::where('username', $request->user_name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['status' => false, 'message' => 'Invalid user name or password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'status' => true,
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        try {

            $request
                ->user()
                ->currentAccessToken()
                ->delete();

            return response(['status' => true, 'message' => 'User logged out']);

        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
