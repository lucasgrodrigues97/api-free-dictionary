<?php

namespace App\Http\Services\Favorites;

use App\Http\Repositories\Favorites\FavoriteRepository;

class FavoriteService
{
    private FavoriteRepository $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function create(int $userId, int $wordId): array
    {
        return $this->favoriteRepository->create($userId, $wordId);
    }

    public function delete(int $userId, int $wordId): array
    {
        return $this->favoriteRepository->delete($userId, $wordId);
    }
}
