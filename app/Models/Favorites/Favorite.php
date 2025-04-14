<?php

namespace App\Models\Favorites;

use App\Enums\Favorites\FavoriteEnum;
use App\Models\User;
use App\Models\Words\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $word_id
 * @property int $status
 * @property-read User $user
 * @property-read Word $word
 */

class Favorite extends Model
{
    use SoftDeletes;

    protected $casts = [
        'status' => FavoriteEnum::class,
    ];
}
