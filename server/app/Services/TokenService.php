<?php

namespace App\Services;

use App\Models\User;

class TokenService
{
    public function generateToken(User $user, $tokenName)
    {
        return $user->createToken($tokenName);
    }
}
