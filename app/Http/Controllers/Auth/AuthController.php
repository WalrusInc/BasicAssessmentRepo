<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth as authFacade;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    // Login a user
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (authFacade::attempt($credentials)) {
            $user = authFacade::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['token' =>$token['token'], 'user' => $user]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
