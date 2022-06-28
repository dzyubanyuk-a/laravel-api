<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Requests\EmailUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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

Route::post('/auth/register', [UserAuthController::class, 'register']);

Route::post('/auth/login', [UserAuthController::class, 'login']);



Route::post('/auth/restore', [UserAuthController::class, 'restore'])
    ->middleware('guest');

Route::post('/auth/restore/confirm', [UserAuthController::class, 'confirm'])->middleware('guest')->name('password.reset');


/*Route::post('/auth/restore/confirm/{token}', [UserAuthController::class, 'confirm'])
    ->middleware('guest')

->name('password.reset');*/





