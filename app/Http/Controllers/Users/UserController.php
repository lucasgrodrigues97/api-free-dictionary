<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(Request $request): JsonResponse
    {
        try {

            return response()->json($this->userService->create($request));

        } catch (Throwable $t) {

            Log::error($t);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 500);
        }
    }

    public function authenticate(Request $request): JsonResponse
    {
        try {

            return response()->json($this->userService->authenticate($request));

        } catch (Throwable $t) {

            Log::error($t);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 500);
        }
    }
}
