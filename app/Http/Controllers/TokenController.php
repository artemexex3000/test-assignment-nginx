<?php

namespace App\Http\Controllers;

use App\Services\StoreTokenService;

class TokenController extends Controller
{
    public function create(StoreTokenService $tokenService)
    {
        return response()->json([
            'success' => true,
            'token' => $tokenService->createToken('API_TOKEN')->token,
        ]);
    }
}
