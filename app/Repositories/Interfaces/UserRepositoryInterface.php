<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

interface UserRepositoryInterface
{
    public function register(RegisterUserRequest $request, $password);
    public function login(LoginUserRequest $request);

}
