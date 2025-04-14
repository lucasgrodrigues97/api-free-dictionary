<?php

namespace App\Http\Repositories\Histories;

use App\Models\Histories\History;
use Illuminate\Database\Eloquent\Builder;

class HistoryRepository
{
    public function get(int $userId, int $wordId): Builder|History|null
    {
        return History::query()
            ->where('user_id', '=', $userId)
            ->where('word_id', '=', $wordId)
            ->first();
    }

    public function create(int $userId, int $wordId): void
    {
        $history = $this->get($userId, $wordId);

        if (!$history) {

            $history = new History();
            $history->user_id = $userId;
            $history->word_id = $wordId;
            $history->save();
        }
    }
}
