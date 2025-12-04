<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8', 
                'regex:/[A-Z]/', 
                'regex:/[0-9]/', 
                'confirmed', 
            ],
            'role' => 'sometimes|in:user,admin',
        ];
    }

    /**
     * Customize the error messages.
     *
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter and one number.',
        ];
    }
}
