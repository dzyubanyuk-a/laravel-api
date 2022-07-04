<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class WorkerController extends Controller
{
    public  function workers(EmployeeRequest $request): \Illuminate\Http\JsonResponse
    {

        $user = Employee::query()->with(['user', 'department', 'worker']);

            if ($request->has('name')) {
                $user
                    ->whereHas('user', function($query)
                    {
                        $query->where('name', '=', request('name'));
                    });
            }


            if ($request->has('department_id')) {
                $user
                    ->whereHas('department', function($query)
                    {
                        $query->where('id', '=', request('department_id'));
                    });

            }

            if ($request->has('worker_id')) {
                $user
                    ->whereHas('worker', function($query)
                    {
                        $query->where('id', '=', request('worker_id'));
                    });

            }


        return response()->json($user->get());
    }
}
