<?php

namespace App\Services\Users;

use App\Http\Requests\LoginUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserGetService
{
    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function register($request):array
    {
        $password = Str::random(6);

        $user = $this->UserRepository->register($request, $password);

        $user = Auth::loginUsingId($user->id, true);

        $token = $user->createToken('API Token')->accessToken;

        return (['user'=>$user, 'token'=>$token, 'password'=>$password]);
    }

    public function login(LoginUserRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['error' => 'Ошибка!']);
        }

        $token = $this->UserRepository->login()->createToken('API Token')->accessToken;

        return (['token'=>$token, 'user'=>auth()->user(), 'password'=>$request->password]);
    }
}
