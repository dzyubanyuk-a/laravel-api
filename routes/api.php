<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Department\DepartmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Регистрация пользователя
Route::post('/auth/register', [UserAuthController::class, 'register']);

//Аутентификация пользователя
Route::post('/auth/login', [UserAuthController::class, 'login']);

//Список отделений с работниками
Route::get('/departments', [DepartmentController::class, 'departments'])
    ->middleware('auth:api');

//Письмо для сброса пароля
Route::post('/auth/restore', [UserAuthController::class, 'restore'])
    ->middleware('guest');

//Сброс пароля
Route::post('/auth/restore/confirm', [UserAuthController::class, 'confirm'])
    ->middleware('guest')
    ->name('password.reset');
