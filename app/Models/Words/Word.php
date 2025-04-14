<?php

namespace App\Models\Words;

use App\Models\Favorites\Favorite;
use App\Models\Histories\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection $histories
 * @property-read Collection $favorites
 */

class Word extends Model
{
    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
