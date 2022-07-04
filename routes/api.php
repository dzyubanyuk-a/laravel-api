<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Worker\WorkerController;
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

Route::controller(UserAuthController::class)->prefix('auth')->group(function () {

    //Регистрация пользователя
    Route::post('/register', 'register')
        ->name('register');

    //Аутентификация пользователя
    Route::post('/login', 'login')
        ->name('login');;

    //Письмо для сброса пароля
    Route::post('/restore', 'restore')
        ->middleware('guest')
        ->name('password.restore');;

    //Сброс пароля
    Route::post('/restore/confirm','confirm')
        ->middleware('guest')
        ->name('password.reset');

});

//Список сотрудников
Route::get('/departments', [DepartmentController::class, 'departments'])
    ->middleware(['auth:api', 'user.role:user,admin,employee']);

//Пользователь
Route::get('/user/{id}', [UserAuthController::class, 'show'])
    ->middleware(['auth:api', 'user.role:admin,employee']);

//Обновление данных пользователя
Route::post('/user', [UserAuthController::class, 'update'])
    ->middleware(['auth:api', 'user.role:admin']);


//Сотрудники
Route::get('/workers', [WorkerController::class, 'workers'])
    ->middleware(['auth:api', 'user.role:admin,employee']);

