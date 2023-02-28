<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{

    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json(
                [
                    'error' => [
                        'code' => 403,
                        'message' => 'Login failed'
                    ]
                ], 403
            );
        }

        $token = $request->bearerToken();
        $user = User::where('user_token', $token)->first();

        if (!$user) return response()->json(
            [
                'error' => [
                    'code' => 403,
                    'message' => 'Login failed'
                ]
            ], 403,
        );

        return $next($request);
    }
}
