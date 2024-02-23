<?php

namespace App\Classes\Services;

use Exception;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Classes\ReferenceCode;
use Illuminate\Support\Facades\DB;
use App\DataTransferObject\EmployeeDto;

class EmployeeService
{
    public  function Index()
    {
        $employees = Employee::orderBy('id', 'desc')->get();
        return $employees;
    }
    public function create(EmployeeDto $employeeDto)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::create([
                "employeeIdentifier" => ReferenceCode::referenceNumber(),
                "name"      => $employeeDto->name,
                "email"     => $employeeDto->email,
                "phoneNumber" => $employeeDto->phoneNumber,
            ]);
            DB::commit();
            return response()->json([
                "status" => true,
                "message" => "Employee Registered Successfully.",
                "data" => $employee,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return [
                $e->getMessage(),
                $e->getLine(),
                $e->getFile()
            ];
        }
    }
    public function view(Employee $employee):Employee
    {
        return $employee;
    }

    public function modifier(Request $request, Employee $employee): Employee
    {
        DB::beginTransaction();
        try {
            $employee->update([
                "name"      => $request->name,
                "email"     => $request->email,
                "phoneNumber" => $request->phoneNumber,
                "status" => $request->status
            ]);
            DB::commit();
            return $employee;
        } catch (Exception $e) {
            DB::rollBack();
            return [
                $e->getMessage(),
                $e->getLine(),
                $e->getFile()
            ];
        }
    }

    public function remove(Employee $employee): bool
    {
        return $employee->delete();
    }
}
