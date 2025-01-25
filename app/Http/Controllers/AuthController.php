<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            return response()->json(['message' => 'User already exists.'], 409); // 409 Conflict
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role' => 'customer',
            'status' => 'active',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Return a success response
        return response()->json([
            'message' => 'Registration successful.',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->status === 'inactive') {
                return response()->json(['message' => 'Your account is deactivated.'], 403);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'Login successful.', 'user' => new UserResource($user), 'token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }
}
