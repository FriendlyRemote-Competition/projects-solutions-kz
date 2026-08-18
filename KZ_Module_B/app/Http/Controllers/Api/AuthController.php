<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $data = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::whereEmail($data['email'])->first();

        if (!$user || !$user->is_active || !Hash::check($data['password'], $user->password))
        {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = str()->random(60);

        $user->update([
            'api_token' => $token
        ]);

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role
                ]
            ]
        ]);
    }
}
