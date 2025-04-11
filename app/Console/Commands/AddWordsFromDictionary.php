<?php

namespace App\Console\Commands;

use App\Http\Services\Words\WordService;
use Illuminate\Console\Command;

class AddWordsFromDictionary extends Command
{
    protected $signature = 'app:add-words-from-dictionary';

    protected $description = 'Add Words From Dictionary';

    public function handle(WordService $wordService): void
    {
        $jsonString = file_get_contents(base_path('words_dictionary.json'));

        $data = json_decode($jsonString, true);

        $wordService->bulkCreate($data);
    }
}
