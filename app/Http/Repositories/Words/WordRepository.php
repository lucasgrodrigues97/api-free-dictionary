<?php

namespace App\Http\Repositories\Words;

use App\Models\Words\Word;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class WordRepository
{
    public function create(string $name): void
    {
        $word = new Word();
        $word->name = $name;
        $word->save();
    }

    public function get(string $word): Builder|Word|null
    {
        return Word::query()
            ->where('name', '=', $word)
            ->first();
    }

    public function getAll(?string $search): Collection
    {
        $words = Word::query();

        if ($search) {

            $words = $words->where('name', 'like', "%$search%");
        }

        return $words->get();
    }
}
