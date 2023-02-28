<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('user_token', $request->bearerToken())
                ->where('role_id', 1)->first();

        if (!$user) return response()->json(
            [
                'error' => [
                    'code' => 403,
                    'message' => 'Forbidden for you'
                ]
            ], 403
        );

        return $next($request);
    }
}
