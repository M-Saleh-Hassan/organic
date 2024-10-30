<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ImportUserArrayRequest extends FormRequest
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
            'users' => 'required|array',
            'users.*.first_name' => 'required|string',
            'users.*.last_name' => 'required|string',
            'users.*.email' => 'required|string|email|max:255|unique:users',
            // 'users.*.password' => 'required|string|min:6',
            'users.*.phone' => 'required|string',
            'users.*.company' => 'required|string',
            'users.*.position' => 'required|string',
            'users.*.role' => 'required|in:subcontractor,builder',
        ];
    }
}
