<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();

        return response([
            "user" => $user
        ], 201); // Good approach put the 201 to constants to prevent magic number

    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                "message" => "User not found"
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response([
                "message" => "Incorrect email or password"
            ], 400);
        }

        // If the email and password match, authenticate the user
        Auth::login($user);

        return response([
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }
}
