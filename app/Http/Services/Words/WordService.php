<?php

namespace App\Http\Services\Words;

use App\Http\Repositories\Words\WordRepository;
use App\Models\Words\Word;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    public function get(string $word): Builder|Word|null
    {
        return $this->wordRepository->get($word);
    }

    public function getAll(Request $request): array
    {
        $search = $request->get('search');
        $limit = $request->get('limit');

        $words = $this->wordRepository->getAll($search);

        $totalDocs = $words->count();

        if ($limit) {

            $words = $words->slice(0, $limit);

            return [
                'results'    => $words->pluck('name')->toArray(),
                'totalDocs'  => $totalDocs,
                'page'       => 1,
                'totalPages' => ceil($totalDocs / $limit),
                'hasNext'    => true,
                'hasPrev'    => false,
            ];
        }

        return [
            'results'    => $words->pluck('name')->toArray(),
            'totalDocs'  => $totalDocs,
            'page'       => 1,
            'totalPages' => 1,
        ];
    }
}
