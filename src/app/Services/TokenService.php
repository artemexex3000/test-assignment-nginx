<?php

namespace App\Services;

use App\Contracts\TokenInterface;
use App\Models\Token;
use Illuminate\Support\Str;

class TokenService implements TokenInterface {
    public function __construct(protected Token $token)
    {

    }

    public function createToken(string $name)
    {
        return $this->token->create([
            'name' => $name,
            'token' => Str::random(64),
            'expires_at' => now()->addMinutes(40),
        ]);
    }
}
