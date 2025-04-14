<?php

namespace App\Http\Repositories\Favorites;

use App\Enums\Favorites\FavoriteEnum;
use App\Models\Favorites\Favorite;

class FavoriteRepository
{
    public function create(int $userId, int $wordId): array
    {
        $favorite = Favorite::query()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->first();

        if (!$favorite) {

            $favorite = new Favorite();
            $favorite->user_id = $userId;
            $favorite->word_id = $wordId;
            $favorite->status = FavoriteEnum::FAVORITED;
            $favorite->save();

            return [
                'message' => trans('validation.favorite_word'),
            ];
        }

        return [
            'message' => trans('validation.already_favorite'),
        ];
    }
}
