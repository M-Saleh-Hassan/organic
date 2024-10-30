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
            'first_name' => 'string',
            'last_name'  => 'string',
            'email'      => 'string|email|max:255|unique:users,email,' . $this->user()->id,
            'phone'      => 'string',
            'company'    => 'string',
            'position'   => 'string',
            'image'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ];
    }
}
