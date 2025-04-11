<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthenticateToken
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
        try {

            $isAuthenticate = Auth::guard('api')->user();

            if (!$isAuthenticate) {

                return response()->json([
                    'message' => 'Token inválido ou não permitido para essa requisição.',
                ]);

            } else {

                $response = $next($request);

                $data = $response->getOriginalContent();

                return response()->json($data);
            }

        } catch (Throwable $t) {

            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Token inválido ou não permitido para essa requisição.',
            ]);
        }
    }
}
