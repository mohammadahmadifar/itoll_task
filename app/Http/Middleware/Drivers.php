<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Drivers
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('driver')) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'error' => 'Access denied.'
        ]);
    }
}
