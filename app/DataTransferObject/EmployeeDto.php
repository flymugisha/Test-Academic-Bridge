<?php
namespace App\DataTransferObject;

use App\Http\Requests\EmployeeRequest;

class EmployeeDto{

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber,
        // public readonly string $status,
    ) {
    }

    public static function formEmployee(EmployeeRequest $request): EmployeeDto
    {
        // dd($request->all());
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('phoneNumber'),
            // $request->validated('status'),
        );
    }
}
