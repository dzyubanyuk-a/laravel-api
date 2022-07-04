<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{

    private DepartmentRepository $DepartmentRepository;

    public function __construct(DepartmentRepository $DepartmentRepository)
    {
        $this->DepartmentRepository = $DepartmentRepository;
    }

    //Вывод списка отделов с сотрудниками
    public function departments(): JsonResponse
    {

        $department = DepartmentResource::collection($this->DepartmentRepository->departments());

        return response()->json($department);
    }
}
