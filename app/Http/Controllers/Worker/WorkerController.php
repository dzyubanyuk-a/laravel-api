<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public  function workers(): \Illuminate\Http\JsonResponse
    {


        return response()->json('test');
    }
}
