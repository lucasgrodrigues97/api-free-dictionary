<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiController extends Controller
{
    private ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function get(string $word): JsonResponse
    {
        try {

            return response()->json($this->apiService->getWord($word));

        } catch (Throwable $e) {

            Log::error($e);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 500);
        }
    }
}
