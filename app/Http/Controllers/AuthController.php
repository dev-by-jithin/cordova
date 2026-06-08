<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email'=> 'required|string|email|unique:users,email',
            'password' => 'required|max:20'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response([
            'user' => $user,
            'message' => 'The user has been created successfully.'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|string|email',
            'password' => 'required|max:20',
        ]);

        if($validator->fails()){
            return response(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response(['status' => false, 'message' => 'Invalid email or password'], 401);
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

        DB::table('personal_access_tokens')
        ->where('tokenable_id', $request->userId)
        ->delete();

        // $request
        //     ->user()
        //     ->currentAccessToken()
        //     ->delete();

        return response(['message' => 'User logged out']);
    }
}
