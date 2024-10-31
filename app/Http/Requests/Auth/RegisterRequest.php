<?php

namespace App\Http\Requests\Auth;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'phone_number'=> 'required|string|max:15',
            'id_type'     => 'required|string|in:passport,national_id',
            'id_number'   => 'required|string|max:50|unique:users',
            'password'    => 'required|string|min:8',
        ];
    }
}
