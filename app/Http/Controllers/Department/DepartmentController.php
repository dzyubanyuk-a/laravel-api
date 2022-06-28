<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{

    private DepartmentRepository $DepartmentRepository;

    public function __construct(DepartmentRepository $DepartmentRepository)
    {
        $this->DepartmentRepository = $DepartmentRepository;
    }

    //Вывод списка отделов с сотрудниками
    public function departments(): Response
    {
        return response($this->DepartmentRepository->departments());
    }
}
