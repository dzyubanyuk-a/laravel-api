<?php

namespace App\Services\Users;

use App\Http\Requests\EmailUserRequest;
use App\Http\Requests\IdUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PasswordUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
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
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $password = Str::random(6);

        $user = $this->UserRepository->register($request, $password);

        if($user) {

            $user = new RegisterResource(User::find($user->id));

            $success['token'] = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $success['token'], 'user' => $user, 'password' => $password]);

        }else{

            return response()->json(['error' => 'Ошибка!'], 401);

        }
    }

    //Логика аутентификации пользователя
    public function login(LoginUserRequest $request):JsonResponse
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = new LoginResource($this->UserRepository->login($request));

            $success['token'] = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $success['token'], 'user' => $user, 'password' => $request->password], 200);

        } else {

            return response()->json(['error' => 'Ошибка!'], 401);

        }

    }

    //Логика  отправки письма для сброса пароля
    public function restore(EmailUserRequest $request): string
    {

        $status = Password::sendResetLink(

            $request->only('email')

        );

        return $status === Password::RESET_LINK_SENT
            ? 'Письмо успешно отправлено'
            : 'Ошибка при отправке письма';

    }

    //Логика сброса пароля
    public function confirm(PasswordUserRequest $request): string
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

    public function show(IdUserRequest $request)
    {

          return new UserResource($this->UserRepository->show($request));

    }

    public function update($request):JsonResponse
    {
        $user = User::findOrFail($request->id);
        $user->update($request->all());




            return response()->json(['message' => 'Good!'], 200);

    }

}
