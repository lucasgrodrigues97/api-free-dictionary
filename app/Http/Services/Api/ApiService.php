<?php

namespace App\Http\Services\Api;

use App\Http\Repositories\Histories\HistoryRepository;
use App\Http\Repositories\Users\UserRepository;
use App\Http\Repositories\Words\WordRepository;
use Illuminate\Support\Facades\Http;

class ApiService
{
    private WordRepository $wordRepository;
    private UserRepository $userRepository;
    private HistoryRepository $historyRepository;

    public function __construct(
        WordRepository    $wordRepository,
        UserRepository    $userRepository,
        HistoryRepository $historyRepository
    )
    {
        $this->wordRepository = $wordRepository;
        $this->userRepository = $userRepository;
        $this->historyRepository = $historyRepository;
    }

    public function getWord(string $wordSearch): array
    {
        $url = env('DICTIONARY_API_URL') . "$wordSearch";

        $response = Http::get($url);

        $data = $response->json();

        // Word not Found
        if (isset($data['title']) && $data['title'] === trans('validation.no_definitions')) {

            return [
                'status'  => false,
                'message' => trans('validation.word_not_found'),
            ];
        }

        $user = $this->userRepository->getCurrentUser();
        $word = $this->wordRepository->get($wordSearch);
        $this->historyRepository->create($user->id, $word->id);

        $details = [];

        $meanings = $data[0]['meanings'];

        foreach ($meanings as $meaning) {

            foreach ($meaning['definitions'] as $data) {

                $details[] = $data['definition'];
            }
        }

        return [
            'details' => $details,
        ];
    }
}
