<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Users\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(Request $request): array
    {
        return $this->userRepository->create($request);
    }

    public function authenticate(Request $request): array
    {
        $data = [
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($data)) {

            return [
                'message' => 'Token gerado com sucesso',
                'data' => [
                    'token' => Auth::user()->createToken('API')->accessToken,
                ]
            ];
        }

        return [
            'message' => 'Invalid credentials.',
        ];
    }
}
