<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $plain = Str::random(64);
        $token = ApiToken::create([
            'user_id' => $user->id,
            'token' => $plain,
            'expires_at' => Carbon::now()->addHours(1),
        ]);

        return response()->json([
            'access_token' => $token->token,
            'token_type' => 'Bearer',
            'message' => 'Login berhasil',
        ]);

    }


    public function logout(Request $request)
    {
        $header = $request->header('Authorization');
        if (!is_string($header) || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $value = substr($header, 7);
        $token = ApiToken::where('token', $value)->first();
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token->delete();
        return response()->json(['message' => 'berhasil']);
    }

}

