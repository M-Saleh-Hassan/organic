<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'string|min:6',
            'phone'      => 'required|string',
            'company'    => 'required|string',
            'position'   => 'required|string',
            'role_id'    => 'required|exists:roles,id',

            'permissions'   => 'array',
            'permissions.*' => 'required_with:permissions|exists:permissions,id',

            'assigned_projects'   => 'array',
            'assigned_projects.*' => 'required_with:assigned_projects|exists:projects,id',

            'invite_message'  => 'string',
        ];
    }
}
