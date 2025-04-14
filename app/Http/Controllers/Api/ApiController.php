<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\ApiService;
use App\Http\Services\Favorites\FavoriteService;
use App\Http\Services\Users\UserService;
use App\Http\Services\Words\WordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiController extends Controller
{
    private ApiService $apiService;
    private WordService $wordService;
    private FavoriteService $favoriteService;
    private UserService $userService;

    public function __construct(
        ApiService      $apiService,
        WordService     $wordService,
        FavoriteService $favoriteService,
        UserService     $userService
    )
    {
        $this->apiService = $apiService;
        $this->wordService = $wordService;
        $this->favoriteService = $favoriteService;
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => trans('validation.challenge'),
        ]);
    }

    public function all(Request $request): JsonResponse
    {
        try {

            return response()->json($this->wordService->getAll($request));

        } catch (Throwable $t) {

            Log::error($t);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 400);
        }
    }

    public function search(string $word): JsonResponse
    {
        try {

            return response()->json($this->apiService->getWord($word));

        } catch (Throwable $t) {

            Log::error($t);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 400);
        }
    }

    public function favorite(string $word): JsonResponse
    {
        try {

            $word = $this->wordService->get($word);

            if ($word) {

                $user = $this->userService->getCurrentUser();

                return response()->json($this->favoriteService->create($user->id, $word->id));
            }

            return response()->json(['message' => trans('validation.word_not_found')]);

        } catch (Throwable $t) {

            Log::error($t);

            return response()->json([
                'status'  => false,
                'message' => trans('validation.something_wrong'),
            ], 400);
        }
    }
}
