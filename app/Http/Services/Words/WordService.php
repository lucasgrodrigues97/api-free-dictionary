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
        $search = $request->input('search');
        $limit = $request->input('limit');

        $words = $this->wordRepository->getAll($search, $limit);

        if ($limit) {

            return [
                'results'    => $words->pluck('name')->toArray(),
                'totalDocs'  => $words->total(),
                'page'       => $words->currentPage(),
                'totalPages' => $words->lastPage(),
                'hasNext'    => $words->hasMorePages(),
                'hasPrev'    => $words->currentPage() > 1,
            ];
        }

        return [
            'results'    => $words->pluck('name')->toArray(),
            'totalDocs'  => $words->count(),
            'page'       => 1,
            'totalPages' => 1,
            'hasNext'    => false,
            'hasPrev'    => false,
        ];
    }
}
