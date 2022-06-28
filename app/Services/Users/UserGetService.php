<?php

namespace App\Services\Users;

use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class UserGetService
{

    private UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    //Логика регистрации пользователя
    public function register($request): array
    {
        $password = Str::random(6);

        $user = $this->UserRepository->register($request, $password);
        $user = Auth::loginUsingId($user->id, true);
        $token = $user->createToken('API Token')->accessToken;

        return (['user'=>$user, 'token'=>$token, 'password'=>$password]);
    }

    //Логика авторизации пользователя
    public function login(LoginUserRequest $request):Response|array
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['error' => 'Ошибка!']);
        }

        $token = $this->UserRepository->login($request)->createToken('API Token')->accessToken;

        return (['token'=>$token, 'user'=>auth()->user(), 'password'=>$request->password]);
    }

    //Логика  отправки письма для сброса пароля
    public function restore(EmailUserRequest $request)
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? 'Письмо успешно отправлено'
            : 'Ошибка при отправке письма';

    }

    //Логика сброса пароля
    public function confirm(PasswordUserRequest $request)
    {

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            });

        return $status === Password::PASSWORD_RESET
            ? 'Пароль успешно обновлен'
            : 'Ошибка при сбросе пароля';
    }

}
