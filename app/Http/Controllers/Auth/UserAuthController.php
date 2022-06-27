<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordUserRequest;
use App\Http\Requests\PasswordwUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Users\UserGetService;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function restore(EmailUserRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }

    public function confirm(PasswordUserRequest $request)
    {
        dd($request);
         $status = Password::reset(
            $request->only('password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();



                event(new PasswordReset($user));
            }
        );


        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }




}
