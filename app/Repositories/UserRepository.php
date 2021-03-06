<?php

namespace App\Repositories;

use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\IdUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class UserRepository implements UserRepositoryInterface
{
    //Создание пользователя
    public function register(RegisterUserRequest $request, $password)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->github = $request->github;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    //Авторизация пользователя
    public function login($request): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public  function show($request)
    {
        return User::find($request->id);
    }

}
