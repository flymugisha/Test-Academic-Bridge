<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\DataTransferObject\EmployeeDto;
use App\Classes\Services\EmployeeService;
use OpenApi\Annotations as OA;

class EmployeeController extends Controller
{

    public function __construct(
        protected EmployeeService $employeeService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = $this->employeeService->index();
        return $employees;
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\ Post(
     *     path="employe",
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\property (name="text",type="string")
     *
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     * )
     */
    public function store(EmployeeRequest $request)
    {

        $employee = $this->employeeService->Create(EmployeeDto::formEmployee($request));
        return $employee;
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = $this->employeeService->view($employee);
        return response()->json([
            "status" => true,
            "data" => $employee,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate(
            [
                "name" => ["required", "string"],
                "email" => ["required", "string", Rule::unique("employees", "email")->ignore($employee->id)],
                "phoneNumber" => ["required", "string", Rule::unique("employees", "phoneNumber")->ignore($employee->id)],
                "status" => "nullable"
            ]
        );
        $employee = $this->employeeService->modifier($request, $employee);
        return response()->json([
            "status" => true,
            "message" => "Employee Updated Successfully.",
            "data" => $employee,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee = $this->employeeService->remove($employee);
        return response()->json([
            "status" => true,
            "message" => "Employee is deleted Successfully.",
        ], 200);
    }
}
