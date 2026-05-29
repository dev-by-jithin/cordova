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
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'name' => 'required|string',
            'email'=> 'required|string|email|unique:users,email',
            'password' => 'required|max:20'
        ]);

        if($errors->fails()){
            return response($errors->errors()->all(), 422);
        }

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        return response([
            'user' => $user,
            'message' => 'The user has been created successfully.'
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'email'=> 'required|string|email',
            'password' => 'required|max:20',
        ]);

        if($errors->fails()){
            return response($errors->errors()->all(), 422);
        }

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response(['message' => 'Invalid email or password'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);


    }

    public function logout(Request $request)
    {
        $userId = $request->userId;

        DB::table('personal_access_tokens')
        ->where('tokenable_id', $userId)
        ->delete();

        // $request
        //     ->user()
        //     ->currentAccessToken()
        //     ->delete();

        return response(['message' => 'User logged out']);
    }
}
