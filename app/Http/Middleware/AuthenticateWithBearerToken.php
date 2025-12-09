<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        if (!is_string($header) || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($header, 7);
        $record = ApiToken::where('token', $token)->first();

       if (!$record) {
        return response()->json(['message' => 'Tokennya salah kocak'], 401);
        }

        if ($record->expires_at && $record->expires_at->isPast()) {
            return response()->json(['message' => 'waktunya abis'], 401);
        }

        if ($record->user) {
            $record->last_used_at = now();
            $record->save();
            Auth::setUser($record->user);
        }

        return $next($request);
    }
}

