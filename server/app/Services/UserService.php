<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function registerUser($userData)
    {
        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        event(new Registered($user));

        return $user;
    }

    public function getUser($email)
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function validatePassword(User $user, $data)
    {
        return Hash::check($data['password'], $user->password);
    }

    public function verifiyUser(User $user)
    {
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    }
}
