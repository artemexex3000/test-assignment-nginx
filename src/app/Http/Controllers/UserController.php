<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Position;
use App\Models\Token;
use App\Models\User;
use App\Services\StoreUserService;
use Illuminate\Http\Request;
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
            return response()->json([
                'success' => false,
                'message' => 'There is no provided token',
            ], 401);
        if ($token->getAttribute('last_used_at'))
            return response()->json([
                'success' => false,
                'message' => 'Provided token has already used',
            ], 401);
        if (!($token->getAttribute('expires_at') > now()->toDateTimeString()))
            return response()->json([
                'success' => false,
                'message' => 'Provided token has expired',
            ], 401);

        $data = $request->validated();
        $user = $storeUserService->create(
            $data['name'],
            $data['email'],
            $data['phone'],
            $request->file('photo'),
            $data['position_id']
        );

        $token->update([
            'last_used_at' => now()->toDateTimeString(),
        ]);

        return response()->json([
            'success' => true,
            'user_id' => $user->getAttribute('id'),
            'message' => 'New user successfully registered',
        ]);
    }

    public function show(Request $request)
    {
        $user = User::all()->find($request->user);
        $position = Position::all()->find($user->value('position_id'))->first()->getAttribute('name');

        return response()->json([
            'success' => true,
            'user' => [
                $user->all()->first(),
                $position,
            ],
        ]);
    }
}
