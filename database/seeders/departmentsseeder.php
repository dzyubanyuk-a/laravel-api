<?php

namespace Database\Seeders;

use App\Domain\Enums\Departments\Departments;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class departmentsseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Departments::cases();


        foreach ($departments as $department) {
            Department::query()->updateOrCreate([
                'name'=>$department->value,
            ]);
        }
    }
}
