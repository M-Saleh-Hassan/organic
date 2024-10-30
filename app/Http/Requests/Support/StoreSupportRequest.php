<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportRequest extends FormRequest
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
            'raised_by'   => 'required|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
            'raised_date' => 'required|date',
            'company'     => 'required|string',
            'description' => 'required|string',
        ];
    }

}
