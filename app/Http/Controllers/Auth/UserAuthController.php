<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Users\UserGetService;
use Illuminate\Http\Response;


class UserAuthController extends Controller
{

    private UserGetService $UserGetService;

    public function __construct(UserGetService $UserGetService)
    {
        $this->UserGetService = $UserGetService;
    }

    //Регистрация пользователя
    public function register(RegisterUserRequest $request): Response
    {
        $user = $this->UserGetService->register($request);

        return response(['token' => $user['token'], 'user' => $user['user'], 'password'=>$user['password']]);
    }

    //Аутентификация пользователя
    public function login(LoginUserRequest $request):Response
    {
        $user = $this->UserGetService->login($request);

        return response(['token' => $user['token'], 'user' => $user['user'], 'password'=>$user['password']]);
    }

    //Ссылка на сброс пароля (пишу в лог)
    public function restore(EmailUserRequest $request): string
    {

       return $this->UserGetService->restore($request);

    }

    //Сброс пароля
    public function confirm(PasswordUserRequest $request): string
    {
        return $this->UserGetService->confirm($request);
    }

}
