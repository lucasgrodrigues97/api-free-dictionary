<?php

namespace App\Http\Repositories\Users;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getCurrentUser(): User|Authenticatable
    {
        return Auth::guard('api')->user();
    }

    public function checkEmail(?string $email): bool
    {
        return User::query()->where('email', '=', $email)->count() > 0;
    }

    public function create(Request $request): array
    {
        $email = $request->input('email');

        if ($this->checkEmail($email)) {

            return [
                'message' => trans('validation.email_exists'),
            ];
        }

        $name = $request->input('name');
        $password = $request->input('password');

        if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $password) {

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            return [
                'id'    => encrypt($user->id),
                'name'  => $name,
                'token' => $user->createToken('API')->accessToken
            ];
        }

        return [
            'message' => trans('validation.invalid_fields'),
        ];
    }
}
