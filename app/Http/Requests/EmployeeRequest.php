<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    "name" => ["required", "string"],
                    "email" => ["required", "string", "unique:employees,email"],
                    "phoneNumber" => ["required", "string", "unique:employees,phoneNumber"],
                    // "status"=>["nullable"]
                ];
                break;
            case 'PATCH':
                return [
                    "name" => ["required", "string"],
                    "email" => ["required", "string", Rule::unique("employees", "email")->ignore($this->email)],
                    "phoneNumber" => ["required", "string", Rule::unique("employees", "phoneNumber")->ignore($this->phoneNumber)],
                    // "status"=>["nullable"]

                ];
                break;
        }
    }
}
