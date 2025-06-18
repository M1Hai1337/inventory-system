<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Cache::remember('employees', 60, function () {
            return Employee::all();
        });

        return EmployeeResource::collection($employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'age' => 'required',
            'address' => 'required',
        ]);

        $employee = Employee::create($request->all());

        return new EmployeeResource($employee);
    }
}
