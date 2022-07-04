<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\IdUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\Users\UserGetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    private UserGetService $UserGetService;

    public function __construct(UserGetService $UserGetService)
    {

        $this->UserGetService = $UserGetService;

    }

    //Регистрация пользователя
    public function register(RegisterUserRequest $request): JsonResponse
    {

        return $this->UserGetService->register($request);

    }

    //Аутентификация пользователя
    public function login(LoginUserRequest $request): JsonResponse
    {

        return $this->UserGetService->login($request);

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

    //Показать данные пользователя
    public function show(IdUserRequest $request)
    {

        return $this->UserGetService->show($request);

    }

    //Обновление данных пользователя
    public function update(Request $request): JsonResponse
    {

        return $this->UserGetService->update($request);
    }

}
