<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    "firstName" => ["required", "string"],
                    "lastName" => ["required", "string"],
                    "email" => ["required", "string", "unique:users,email"],
                    "phone" => ["required", "string", "unique:users,phone"],
                    "password"      => ["required", "string", Password::min(8)->letters()->numbers()->mixedCase()]

                ];
                break;
            case 'PATCH':
                return [
                    "firstName" => ["required", "string"],
                    "lastName" => ["required", "string"],
                    "email" => ["required", "string", Rule::unique("users", "email")->ignore($this->email)],
                    "phone" => ["required", "string", Rule::unique("users", "phone")->ignore($this->phone)],
                ];
                break;
        }
    }
}
