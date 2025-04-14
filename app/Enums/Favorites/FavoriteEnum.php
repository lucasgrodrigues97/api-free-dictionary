<?php

namespace App\Enums\Favorites;

enum FavoriteEnum: int
{
    case DEFAULT = 1;
    case FAVORITED = 2;
    case UNFAVORITED = 3;

    public function isUnfavorited(): bool
    {
        return $this === self::UNFAVORITED;
    }
}
