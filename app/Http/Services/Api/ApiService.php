<?php

namespace App\Http\Services\Api;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function getWord(string $word): array
    {
        $url = env('DICTIONARY_API_URL') . "$word";

        $response = Http::get($url);

        $data = $response->json();

        // Word not Found
        if (isset($data['title']) && $data['title'] === trans('validation.no_definitions')) {

            return [
                'status'  => false,
                'message' => trans('validation.word_not_found'),
            ];
        }

        $meanings = $data[0]['meanings'];
    }
}
