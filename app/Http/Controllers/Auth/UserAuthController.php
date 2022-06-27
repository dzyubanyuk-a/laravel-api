<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\services\Paste\PastesGetService;
use App\Services\Users\UserGetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class UserAuthController extends Controller
{

    private UserGetService $UserGetService;

    public function __construct(UserGetService $UserGetService)
    {
        $this->UserGetService = $UserGetService;
    }

    //Регистрация пользователя
    public function register(RegisterUserRequest $request)
    {
        $user = $this->UserGetService->register($request);
        return response(['token' => $user['token'], 'user' => $user['user'], 'password'=>$user['password']]);
    }

    //Аутентификация пользователя
    public function login(LoginUserRequest $request)
    {
        $user = $this->UserGetService->login($request);
        return response(['token' => $user['token'], 'user' => $user['user'], 'password'=>$user['password']]);
    }

}
