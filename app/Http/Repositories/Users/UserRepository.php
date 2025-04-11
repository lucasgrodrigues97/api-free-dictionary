<?php

namespace App\Http\Repositories\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(Request $request): array
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $password) {

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            return [
                'id'   => encrypt($user->id),
                'name' => $name,
            ];
        }

        return [
            'message' => 'Invalid name, email or password.',
        ];
    }
}
