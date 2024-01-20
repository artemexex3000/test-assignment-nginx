<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Token;
use App\Services\StoreUserService;
use Illuminate\Session\TokenMismatchException;

class UserController extends Controller
{
    /**
     * @throws TokenMismatchException
     */
    public function store(CreateUserRequest $request, StoreUserService $storeUserService)
    {
        $token = Token::query()->where('token', '=', $request->bearerToken())->first();

        if (!$token)
            throw new TokenMismatchException('There is no provided token.');
        if ($token->getAttribute('last_used_at'))
            throw new TokenMismatchException('Provided token has already used.');
        if (!($token->getAttribute('expires_at') > now()->toDateTimeString()))
            throw new TokenMismatchException('Provided token has expired.');


        $data = $request->validated();
        $storeUserService->create(
            $data['name'],
            $data['email'],
            $data['phone'],
            $request->file('photo'),
            $data['position_id']
        );

        $token->update([
            'last_used_at' => now()->toDateTimeString(),
        ]);
    }
}
