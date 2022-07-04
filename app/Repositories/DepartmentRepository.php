<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    //Список отделений с сотрудниками
    public function departments(): \Illuminate\Database\Eloquent\Collection
    {
        return Department::all();
    }
}
