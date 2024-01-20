<?php

namespace App\Services;

use App\Contracts\CreateUserInterface;
use App\Models\User;

class StoreUserService implements CreateUserInterface
{
    public function __construct(protected User $user)
    {

    }

    public function create(
        string $name,
        string $email,
        string $phone,
        string $photo,
        string $position_id
    ): User
    {
        return $this->user->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'photo' => $photo,
            'position_id' => $position_id
        ]);
    }
}
