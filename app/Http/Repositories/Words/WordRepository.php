<?php

namespace App\Http\Repositories\Words;

use App\Models\Words\Word;

class WordRepository
{
    public function create(string $name): void
    {
        $word = new Word();
        $word->name = $name;
        $word->save();
    }
}
