<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'full_name'   => 'string|max:255',
            'email'       => 'string|email|max:255|unique:users,email,' . $this->user()->id,
            'phone_number'=> 'string|unique:users,email,' . $this->user()->id,
            'id_type'     => 'string|in:passport,national_id',
            'id_number'   => 'string|max:50|unique:users,email,' . $this->user()->id,
            'password'    => 'string|min:8',
        ];
    }
}
