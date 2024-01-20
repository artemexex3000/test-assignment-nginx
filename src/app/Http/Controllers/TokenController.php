<?php

namespace App\Http\Controllers;

use App\Services\TokenService;

class TokenController extends Controller
{
    public function create(TokenService $tokenService)
    {
        return response()->json([
            'success' => true,
            'token' => $tokenService->createToken('API_TOKEN')->token,
        ]);
    }
}
