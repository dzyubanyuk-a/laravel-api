<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\RegisterUserRequest;

interface UserRepositoryInterface
{
    public function register(RegisterUserRequest $request, $password);
    public function login();
}
