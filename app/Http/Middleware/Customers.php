<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Customers
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('customer')) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'error' => 'Access denied.'
        ]);
    }
}
