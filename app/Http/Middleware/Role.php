<?php

namespace App\Http\Middleware;

use App\Domain\Enums\Roles\Roles;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return response()->json('Не авторизован!');
        }


        $arrRoles = [];

        foreach ( Roles::cases() as $case ) {
            $arrRoles[$case->value] = $case->name;
        }

        foreach ($roles as $role)
        {
            if(Auth::user()->role == array_search($role, $arrRoles)){
                return $next($request);
            }
        }

        return response()->json('У вас недостаточно прав!');

    }

    public function roles()
    {
        return [
            1=>'admin',
            2=>'employee',
            3=>'user',
        ];

    }

}
