<?php

namespace App\Http\Services\Words;

use App\Http\Repositories\Words\WordRepository;

class WordService
{
    private WordRepository $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function bulkCreate(array $data): void
    {
        foreach (array_keys($data) as $name) {

            $this->wordRepository->create($name);
        }
    }
}
