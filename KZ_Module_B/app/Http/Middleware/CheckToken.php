<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $user = $token ? User::whereApiToken($token)->where('is_active', true)->first() : null;



        if (!$user)
        {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
