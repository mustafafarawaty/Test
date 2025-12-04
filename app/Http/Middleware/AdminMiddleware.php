<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();

        if (! $user || $user->role !== 'admin') {
            return response()->json(['error' => 'Forbidden.'], 403);
        }

        return $next($request);
    }
}
