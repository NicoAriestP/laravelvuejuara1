<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken() ||
            !User::query()->where('role_id', 1)->where('api_token', $request->bearerToken())->exists()
        ) {
            abort(403, $request->bearerToken());
        }

        return $next($request);
    }
}
