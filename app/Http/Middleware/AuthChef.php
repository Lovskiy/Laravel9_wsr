<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthChef
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('user_token', $request->bearerToken())
            ->where('role_id', 3)->first();

        return $next($request);
    }
}
