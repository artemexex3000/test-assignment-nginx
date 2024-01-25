<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Token;
use App\Models\User;
use App\Services\StoreImageUserService;
use App\Services\StoreUserService;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = Validator::make(request()->all(),
            [
                'page' => 'integer|min:1',
                'count' => 'integer|min:1|max:100',
            ]
        )->errors();

        if ($data->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $data->getMessageBag(),
            ], 422);
        }

        $user = User::orderBy('created_at', 'desc')->paginate(request()->count);

        if ($user->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'page' => $user->currentPage(),
            'total_pages' => ceil($user->total() / $user->count()),
            'total_users' => $user->total(),
            'count' => $user->count(),
            'links' => [
                'next_url' => $user->nextPageUrl() ? $user->nextPageUrl() . "&count=" . request()->count : null,
                'prev_url' => $user->previousPageUrl() ? $user->previousPageUrl() . "&count=" . request()->count : null,
            ],
            'users' => $user->items(),
        ]);
    }

    /**
     * @throws TokenMismatchException
     */
    public function store(CreateUserRequest $request, StoreUserService $storeUserService, StoreImageUserService $storeImageUserService)
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
            $storeImageUserService->crop($request->file('photo')),
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

    public function show($id)
    {
        if (Validator::make([$id], ['integer'])->errors()->count() == 1) {
            return response()->json([
                'success' => false,
                'message' => "Validation failed",
                'fails' => [
                    'user_id' => [
                        'The user_id must be an integer.'
                    ]
                ],
            ], 404);
        }
        if (!$user = User::find($id)) {
            return response()->json([
                'success' => false,
                'message' => "The user with the requested identifier does not exist",
                'fails' => [
                    'user_id' => [
                        'User not found'
                    ]
                ],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'position' => $user->position->name,
                'position_id' => $user->position_id,
                'photo' => $user->photo,
            ],
        ]);
    }
}
