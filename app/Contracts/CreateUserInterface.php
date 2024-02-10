<?php

namespace App\Contracts;

use App\Models\User;

interface CreateUserInterface
{
    public function create(string $name, string $email, string $phone, string $photo, string $position_id): User;
}
