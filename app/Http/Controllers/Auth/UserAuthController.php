<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class UserAuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {

        $passwordHash = bcrypt($password = Str::random(6));

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->github = $request->github;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->password = $passwordHash;
        $user->save();

        $user_m = Auth::loginUsingId($user->id, true);

        $token = $user->createToken('API Token')->accessToken;

        return response(['token' => $token, 'user' => $user_m, 'password'=>$password]);
    }

    public function login(LoginUserRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['error' => 'Ошибка!']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['token' => $token, 'user' => auth()->user(), 'password'=>$request->password ]);

    }
}
