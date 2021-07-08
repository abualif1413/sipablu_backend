<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppAuthMiddleware
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
        $user = \App\Http\Controllers\MasterData\UserController::breakToken($request->bearerToken());

        if(!$user)
            return response()->json(["success" => 0, "message" => "Un-authenticated user has detected. Go away and fuck yourself"], 422);

        return $next($request);
    }
}
