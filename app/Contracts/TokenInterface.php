<?php

namespace App\Contracts;

interface TokenInterface
{
    public function createToken(string $name);
}
