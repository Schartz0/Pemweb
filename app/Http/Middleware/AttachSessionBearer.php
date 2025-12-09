<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachSessionBearer
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        if (!is_string($header) || !str_starts_with($header, 'Bearer ')) {
            $token = $request->session()->get('access_token');
            if (is_string($token) && $token !== '') {
                $request->headers->set('Authorization', 'Bearer '.$token);
            }
        }

        return $next($request);
    }
}

