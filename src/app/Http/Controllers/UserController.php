<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\StoreUserService;

class UserController extends Controller
{
    public function store(CreateUserRequest $request, StoreUserService $storeUserService)
    {
        $data = $request->validated();
        $storeUserService->create(
            $data['name'],
            $data['email'],
            $data['phone'],
            $request->file('photo'),
            $data['position_id']
        );
    }
}
