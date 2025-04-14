<?php

namespace App\Http\Repositories\Favorites;

use App\Enums\Favorites\FavoriteEnum;
use App\Models\Favorites\Favorite;
use Illuminate\Database\Eloquent\Builder;

class FavoriteRepository
{
    public function get(int $userId, int $wordId): Builder|Favorite|null
    {
        return Favorite::query()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->first();
    }

    public function create(int $userId, int $wordId): array
    {
        $favorite = $this->get($userId, $wordId);

        if ($favorite) {

            if ($favorite->status->isUnfavorited()) {

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

        $favorite = new Favorite();
        $favorite->user_id = $userId;
        $favorite->word_id = $wordId;
        $favorite->status = FavoriteEnum::FAVORITED;
        $favorite->save();

        return [
            'message' => trans('validation.favorite_word'),
        ];
    }

    public function delete(int $userId, int $wordId): array
    {
        $favorite = $this->get($userId, $wordId);

        if ($favorite) {

            if ($favorite->status->isUnfavorited()) {

                return [
                    'message' => trans('validation.already_unfavorite'),
                ];
            }

            $favorite->status = FavoriteEnum::UNFAVORITED;
            $favorite->save();

            return [
                'message' => trans('validation.unfavorite_word'),
            ];
        }

        return [
            'message' => trans('validation.not_favorite'),
        ];
    }
}
