<?php

namespace App\Http\Services\Users;

use App\Enums\Favorites\FavoriteEnum;
use App\Http\Repositories\Users\UserRepository;
use App\Models\Favorites\Favorite;
use App\Models\Histories\History;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUser(): User|Authenticatable
    {
        return $this->userRepository->getCurrentUser();
    }

    public function create(Request $request): array
    {
        return $this->userRepository->create($request);
    }

    public function authenticate(Request $request): array
    {
        $data = [
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($data)) {

            return [
                'message' => trans('validation.token_generated'),
                'data' => [
                    'token' => Auth::user()->createToken('API')->accessToken,
                ]
            ];
        }

        return [
            'message' => trans('validation.invalid_credentials'),
        ];
    }

    public function show(): array
    {
        $user = $this->getCurrentUser();

        return [
            'name'  => $user->name,
            'email' => $user->email,
            'added' => $user->created_at->format('d/m/Y H:i:s'),
        ];
    }

    public function history(): array
    {
        $user = $this->getCurrentUser();

        $data = [];

        /* @var History $history */

        foreach ($user->histories as $history) {

            $data[] = [
                'word'  => $history->word->name,
                'added' => $history->created_at->format('d/m/Y H:i:s'),
            ];
        }

        return $data;
    }

    public function favorites(): array
    {
        $user = $this->getCurrentUser();

        $favorites = $user->favorites->where('status', FavoriteEnum::FAVORITED);

        $data = [];

        /* @var Favorite $favorite */

        foreach ($favorites as $favorite) {

            $data[] = [
                'word'  => $favorite->word->name,
                'added' => $favorite->created_at->format('d/m/Y H:i:s'),
            ];
        }

        return $data;
    }
}
