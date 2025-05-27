<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8',
            ]
        );

        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        return response() -> json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 201);
    }

    public function login(Request $request)
    {
        $request -> validate(
            [
            'email' => 'required|email',
            'password' => 'required',
            ]
            
        );

        if (!auth()-> attempt($request->only('email', 'password')))
        {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(
            [
                'token' => auth()->user()->createToken('auth_token')->plainTextToken,
                'user' => auth()->user()
            ]
        );
    }
}
