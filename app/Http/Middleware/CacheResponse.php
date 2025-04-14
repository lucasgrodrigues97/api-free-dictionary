<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $key = 'response_cache:' . md5($request->fullUrl());

        $start = microtime(true);

        if (Cache::has($key)) {

            $cached = Cache::get($key);

            return response()->json($cached['body'], 200, array_merge(
                $cached['headers'],
                ['x-cache' => 'HIT', 'x-response-time' => round((microtime(true) - $start) * 1000) . 'ms']
            ));
        }

        $response = $next($request);

        $data = [
            'headers' => $response->headers->all(),
            'body'    => $response->getOriginalContent(),
        ];

        Cache::put($key, $data, now()->addMinutes(60));

        $response->headers->set('x-cache', 'MISS');
        $response->headers->set('x-response-time', round((microtime(true) - $start) * 1000) . 'ms');

        return $response;
    }
}
